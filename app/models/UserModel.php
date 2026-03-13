<?php
class UserModel {
    private $conn;
    private $table = 'users';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Register new user
    public function register($data) {
        // Check if username or email exists
        $check_query = "SELECT id FROM " . $this->table . " WHERE username = ? OR email = ?";
        $check_stmt = $this->conn->prepare($check_query);
        $check_stmt->bind_param("ss", $data['username'], $data['email']);
        $check_stmt->execute();
        $result = $check_stmt->get_result();
        
        if ($result->num_rows > 0) {
            return ['success' => false, 'error' => 'Username or email already exists'];
        }

        // Hash password
        $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);
        
        // Generate unique avatar filename for each user
        $unique_id = uniqid();
        $profile_image = 'avatar_' . $data['username'] . '_' . $unique_id . '.jpg';
        
        // Insert user
        $query = "INSERT INTO " . $this->table . " 
                  (username, email, password, full_name, bio, profile_image, location, website, favorite_game) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        
        $location = $data['location'] ?? '';
        $website = $data['website'] ?? '';
        $favorite_game = $data['favorite_game'] ?? '';
        
        $stmt->bind_param("sssssssss", 
            $data['username'], $data['email'], $hashed_password, $data['full_name'], 
            $data['bio'], $profile_image, $location, $website, $favorite_game
        );
        
        if ($stmt->execute()) {
            return ['success' => true, 'user_id' => $stmt->insert_id];
        }
        
        return ['success' => false, 'error' => 'Registration failed'];
    }

    // Login user
    public function login($username, $password) {
        $query = "SELECT * FROM " . $this->table . " WHERE username = ? OR email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss", $username, $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
            if (password_verify($password, $user['password'])) {
                unset($user['password']);
                return ['success' => true, 'user' => $user];
            }
        }
        
        return ['success' => false, 'error' => 'Invalid username or password'];
    }

    // Get user by ID - FIXED to ensure profile_image is returned correctly
    public function getUserById($id) {
        $query = "SELECT id, username, email, full_name, bio, profile_image, cover_image, 
                  location, website, favorite_game, level, xp, created_at 
                  FROM " . $this->table . " WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
            // IMPORTANT FIX: Ensure profile_image has a value
            if (empty($user['profile_image'])) {
                $user['profile_image'] = 'default-avatar.png';
            }
            if (empty($user['cover_image'])) {
                $user['cover_image'] = 'default-cover.jpg';
            }
            
            return $user;
        }
        
        return null;
    }

    // Update profile - FIXED to handle image upload
    public function updateProfile($id, $data) {
        // Check if we need to update profile_image
        if (isset($data['profile_image']) && !empty($data['profile_image'])) {
            $query = "UPDATE " . $this->table . " 
                      SET full_name = ?, bio = ?, profile_image = ?, location = ?, 
                          website = ?, favorite_game = ?
                      WHERE id = ?";
            
            $stmt = $this->conn->prepare($query);
            
            $full_name = $data['full_name'] ?? '';
            $bio = $data['bio'] ?? '';
            $location = $data['location'] ?? '';
            $website = $data['website'] ?? '';
            $favorite_game = $data['favorite_game'] ?? '';
            $profile_image = $data['profile_image'];
            
            $stmt->bind_param("ssssssi", $full_name, $bio, $profile_image, $location, 
                            $website, $favorite_game, $id);
        } else {
            // Update without changing profile_image
            $query = "UPDATE " . $this->table . " 
                      SET full_name = ?, bio = ?, location = ?, website = ?, favorite_game = ?
                      WHERE id = ?";
            
            $stmt = $this->conn->prepare($query);
            
            $full_name = $data['full_name'] ?? '';
            $bio = $data['bio'] ?? '';
            $location = $data['location'] ?? '';
            $website = $data['website'] ?? '';
            $favorite_game = $data['favorite_game'] ?? '';
            
            $stmt->bind_param("sssssi", $full_name, $bio, $location, $website, 
                            $favorite_game, $id);
        }
        
        return $stmt->execute();
    }

    // Search users
    public function searchUsers($keyword) {
        if (empty($keyword)) {
            $query = "SELECT id, username, full_name, profile_image, level 
                      FROM " . $this->table . " 
                      ORDER BY RAND()
                      LIMIT 10";
            $stmt = $this->conn->prepare($query);
        } else {
            $query = "SELECT id, username, full_name, profile_image, level 
                      FROM " . $this->table . " 
                      WHERE username LIKE ? OR full_name LIKE ? 
                      ORDER BY level DESC 
                      LIMIT 20";
            $stmt = $this->conn->prepare($query);
            $search_term = "%" . $keyword . "%";
            $stmt->bind_param("ss", $search_term, $search_term);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        
        $users = [];
        while ($row = $result->fetch_assoc()) {
            // FIX: Ensure profile_image has a value
            if (empty($row['profile_image'])) {
                $row['profile_image'] = 'default-avatar.png';
            }
            $users[] = $row;
        }
        
        return $users;
    }

    // Get user posts count
    public function getUserPostsCount($user_id) {
        $query = "SELECT COUNT(*) as count FROM posts WHERE user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['count'];
    }
}
?>