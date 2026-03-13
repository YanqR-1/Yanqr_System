<?php
class LikeModel {
    private $conn;
    private $table = 'likes';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Toggle like
    public function toggleLike($post_id, $user_id) {
        // Check if like exists
        $check_query = "SELECT id FROM " . $this->table . " WHERE post_id = ? AND user_id = ?";
        $check_stmt = $this->conn->prepare($check_query);
        $check_stmt->bind_param("ii", $post_id, $user_id);
        $check_stmt->execute();
        $result = $check_stmt->get_result();
        
        if ($result->num_rows > 0) {
            // Unlike
            $query = "DELETE FROM " . $this->table . " WHERE post_id = ? AND user_id = ?";
            $action = 'unliked';
        } else {
            // Like
            $query = "INSERT INTO " . $this->table . " (post_id, user_id) VALUES (?, ?)";
            $action = 'liked';
        }
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $post_id, $user_id);
        
        if ($stmt->execute()) {
            $this->updateLikeCount($post_id);
            $count = $this->getLikeCount($post_id);
            
            return [
                'success' => true,
                'action' => $action,
                'count' => $count
            ];
        }
        
        return ['success' => false];
    }

    // Get like count
    public function getLikeCount($post_id) {
        $query = "SELECT COUNT(*) as count FROM " . $this->table . " WHERE post_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        return $row['count'];
    }

    // Check if user liked post
    public function hasUserLiked($post_id, $user_id) {
        $query = "SELECT id FROM " . $this->table . " WHERE post_id = ? AND user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $post_id, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->num_rows > 0;
    }

    // Update like count in posts
    private function updateLikeCount($post_id) {
        $query = "UPDATE posts SET like_count = (
                    SELECT COUNT(*) FROM likes WHERE post_id = ?
                  ) WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $post_id, $post_id);
        $stmt->execute();
    }
}
?>