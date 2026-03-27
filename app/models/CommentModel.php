<?php
class CommentModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($post_id, $user_id, $content) {
        $content = htmlspecialchars(strip_tags($content));
        $stmt = $this->conn->prepare("INSERT INTO comments (post_id, user_id, content) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $post_id, $user_id, $content);
        
        if ($stmt->execute()) {
            $this->updatePostCommentCount($post_id);
            return true;
        }
        return false;
    }

    public function getByPost($post_id) {
        $stmt = $this->conn->prepare("
            SELECT c.*, u.username, u.avatar 
            FROM comments c 
            JOIN users u ON c.user_id = u.id 
            WHERE c.post_id = ? 
            ORDER BY c.created_at ASC
        ");
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $comments = [];
        while ($row = $result->fetch_assoc()) {
            $comments[] = $row;
        }
        return $comments;
    }

    public function delete($id, $user_id) {
        // Get post_id first
        $get_post = $this->conn->prepare("SELECT post_id FROM comments WHERE id = ?");
        $get_post->bind_param("i", $id);
        $get_post->execute();
        $result = $get_post->get_result();
        $comment = $result->fetch_assoc();
        $post_id = $comment['post_id'];
        
        // Delete comment
        $stmt = $this->conn->prepare("DELETE FROM comments WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $id, $user_id);
        
        if ($stmt->execute()) {
            $this->updatePostCommentCount($post_id);
            return true;
        }
        return false;
    }

    private function updatePostCommentCount($post_id) {
        $stmt = $this->conn->prepare("UPDATE posts SET comments_count = (SELECT COUNT(*) FROM comments WHERE post_id = ?) WHERE id = ?");
        $stmt->bind_param("ii", $post_id, $post_id);
        $stmt->execute();
    }
}
?>