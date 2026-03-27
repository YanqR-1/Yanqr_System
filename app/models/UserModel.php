<?php
class UserModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register($username, $email, $password, $full_name = '', $bio = '') {
        // Check if user exists
        $check = $this->conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $check->bind_param("ss", $username, $email);
        $check->execute();
        $result = $check->get_result();
        
        if ($result->num_rows > 0) {
            return false;
        }
        
        // Hash password
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert user
        $stmt = $this->conn->prepare("INSERT INTO users (username, email, password, full_name, bio) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $username, $email, $hashed, $full_name, $bio);
        
        return $stmt->execute();
    }

    public function login($username, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                unset($user['password']);
                return $user;
            }
        }
        return false;
    }

    public function getUserById($id) {
        $stmt = $this->conn->prepare("SELECT id, username, email, full_name, bio, avatar, created_at FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function updateAvatar($id, $avatar) {
        $stmt = $this->conn->prepare("UPDATE users SET avatar = ? WHERE id = ?");
        $stmt->bind_param("si", $avatar, $id);
        return $stmt->execute();
    }

    public function updateProfile($id, $full_name, $bio) {
        $stmt = $this->conn->prepare("UPDATE users SET full_name = ?, bio = ? WHERE id = ?");
        $stmt->bind_param("ssi", $full_name, $bio, $id);
        return $stmt->execute();
    }
}
?>