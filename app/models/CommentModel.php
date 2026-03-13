<?php
class CommentModel {
    private $conn;
    private $table = 'comments';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create comment
    public function create($post_id, $user_id, $content) {
        $query = "INSERT INTO " . $this->table . " (post_id, user_id, content) 
                  VALUES (?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        $content = $content;
        $stmt->bind_param("iis", $post_id, $user_id, $content);
        
        if ($stmt->execute()) {
            $this->updateCommentCount($post_id);
            return ['success' => true, 'comment_id' => $stmt->insert_id];
        }
        
        return ['success' => false, 'error' => 'Failed to add comment'];
    }

    // Get comment by ID
    public function getCommentById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_assoc();
    }

    // Update comment
    public function update($id, $user_id, $content) {
        $query = "UPDATE " . $this->table . " 
                  SET content = ? 
                  WHERE id = ? AND user_id = ?";
        
        $stmt = $this->conn->prepare($query);
        $content = $content;
        $stmt->bind_param("sii", $content, $id, $user_id);
        
        return $stmt->execute();
    }

    // Delete comment
    public function delete($id, $user_id) {
        $comment = $this->getCommentById($id);
        $post_id = $comment['post_id'];
        
        $query = "DELETE FROM " . $this->table . " WHERE id = ? AND user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $id, $user_id);
        
        if ($stmt->execute()) {
            $this->updateCommentCount($post_id);
            return true;
        }
        
        return false;
    }

    // Update comment count in posts
    private function updateCommentCount($post_id) {
        $query = "UPDATE posts SET comment_count = (
                    SELECT COUNT(*) FROM comments WHERE post_id = ?
                  ) WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $post_id, $post_id);
        $stmt->execute();
    }
}
?>