<?php
class PostModel {
    private $conn;
    private $table = 'posts';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create post
    public function create($user_id, $data) {
        $query = "INSERT INTO " . $this->table . " (user_id, content, image, game_tag) 
                  VALUES (?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        
        $content = $data['content'];
        $game_tag = $data['game_tag'] ?? '';
        $image = $data['image'] ?? null;
        
        $stmt->bind_param("isss", $user_id, $content, $image, $game_tag);
        
        if ($stmt->execute()) {
            return ['success' => true, 'post_id' => $stmt->insert_id];
        }
        
        return ['success' => false, 'error' => 'Failed to create post'];
    }

    // Get all posts for feed - FIXED to include profile_image
    public function getAllPosts($user_id = null, $limit = 20) {
        $query = "SELECT p.*, u.username, u.full_name, u.profile_image, u.level,
                  (SELECT COUNT(*) > 0 FROM likes WHERE post_id = p.id AND user_id = ?) as user_liked
                  FROM " . $this->table . " p
                  JOIN users u ON p.user_id = u.id
                  ORDER BY p.created_at DESC
                  LIMIT ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $user_id, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $posts = [];
        while ($row = $result->fetch_assoc()) {
            // FIX: Ensure profile_image has a value
            if (empty($row['profile_image'])) {
                $row['profile_image'] = 'default-avatar.png';
            }
            $row['comments'] = $this->getPostComments($row['id']);
            $posts[] = $row;
        }
        
        return $posts;
    }

    // Get posts by user - FIXED to include profile_image
    public function getPostsByUser($user_id, $viewer_id = null, $limit = 20) {
        $query = "SELECT p.*, u.username, u.full_name, u.profile_image, u.level,
                  (SELECT COUNT(*) > 0 FROM likes WHERE post_id = p.id AND user_id = ?) as user_liked
                  FROM " . $this->table . " p
                  JOIN users u ON p.user_id = u.id
                  WHERE p.user_id = ?
                  ORDER BY p.created_at DESC
                  LIMIT ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iii", $viewer_id, $user_id, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $posts = [];
        while ($row = $result->fetch_assoc()) {
            // FIX: Ensure profile_image has a value
            if (empty($row['profile_image'])) {
                $row['profile_image'] = 'default-avatar.png';
            }
            $row['comments'] = $this->getPostComments($row['id']);
            $posts[] = $row;
        }
        
        return $posts;
    }

    // Get single post
    public function getPostById($id, $user_id = null) {
        $query = "SELECT p.*, u.username, u.full_name, u.profile_image, u.level
                  FROM " . $this->table . " p
                  JOIN users u ON p.user_id = u.id
                  WHERE p.id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $post = $result->fetch_assoc();
            if (empty($post['profile_image'])) {
                $post['profile_image'] = 'default-avatar.png';
            }
            return $post;
        }
        
        return null;
    }

    // Update post
    public function update($id, $user_id, $content) {
        $query = "UPDATE " . $this->table . " 
                  SET content = ? 
                  WHERE id = ? AND user_id = ?";
        
        $stmt = $this->conn->prepare($query);
        $content = $content;
        $stmt->bind_param("sii", $content, $id, $user_id);
        
        return $stmt->execute();
    }

    // Delete post
    public function delete($id, $user_id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = ? AND user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $id, $user_id);
        
        return $stmt->execute();
    }

    // Search posts
    public function searchPosts($keyword) {
        $query = "SELECT p.*, u.username, u.full_name, u.profile_image, u.level
                  FROM " . $this->table . " p
                  JOIN users u ON p.user_id = u.id
                  WHERE p.content LIKE ?
                  ORDER BY p.created_at DESC
                  LIMIT 50";
        
        $stmt = $this->conn->prepare($query);
        $search_term = "%" . $keyword . "%";
        $stmt->bind_param("s", $search_term);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $posts = [];
        while ($row = $result->fetch_assoc()) {
            if (empty($row['profile_image'])) {
                $row['profile_image'] = 'default-avatar.png';
            }
            $posts[] = $row;
        }
        
        return $posts;
    }

    // Get post comments
    private function getPostComments($post_id) {
        $query = "SELECT c.*, u.username, u.full_name, u.profile_image
                  FROM comments c
                  JOIN users u ON c.user_id = u.id
                  WHERE c.post_id = ?
                  ORDER BY c.created_at ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $comments = [];
        while ($row = $result->fetch_assoc()) {
            if (empty($row['profile_image'])) {
                $row['profile_image'] = 'default-avatar.png';
            }
            $comments[] = $row;
        }
        
        return $comments;
    }
}
?>