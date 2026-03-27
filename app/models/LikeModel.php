<?php
class LikeModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function toggle($post_id, $user_id) {
        // Check if like exists
        $check = $this->conn->prepare("SELECT id FROM likes WHERE post_id = ? AND user_id = ?");
        $check->bind_param("ii", $post_id, $user_id);
        $check->execute();
        $result = $check->get_result();
        
        if ($result->num_rows > 0) {
            // Unlike
            $stmt = $this->conn->prepare("DELETE FROM likes WHERE post_id = ? AND user_id = ?");
            $stmt->bind_param("ii", $post_id, $user_id);
            $action = 'unliked';
        } else {
            // Like
            $stmt = $this->conn->prepare("INSERT INTO likes (post_id, user_id) VALUES (?, ?)");
            $stmt->bind_param("ii", $post_id, $user_id);
            $action = 'liked';
        }
        
        if ($stmt->execute()) {
            $this->updatePostLikesCount($post_id);
            $count = $this->getLikeCount($post_id);
            
            return [
                'success' => true,
                'action' => $action,
                'count' => $count
            ];
        }
        
        return ['success' => false];
    }

    public function getLikeCount($post_id) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as count FROM likes WHERE post_id = ?");
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['count'];
    }

    private function updatePostLikesCount($post_id) {
        $stmt = $this->conn->prepare("UPDATE posts SET likes_count = (SELECT COUNT(*) FROM likes WHERE post_id = ?) WHERE id = ?");
        $stmt->bind_param("ii", $post_id, $post_id);
        $stmt->execute();
    }
}
?>