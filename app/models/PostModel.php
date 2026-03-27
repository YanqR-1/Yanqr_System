<?php
class PostModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($user_id, $content) {
        $content = htmlspecialchars(strip_tags($content));
        $stmt = $this->conn->prepare("INSERT INTO posts (user_id, content) VALUES (?, ?)");
        $stmt->bind_param("is", $user_id, $content);
        return $stmt->execute();
    }

    public function getAll($user_id = null) {
        $sql = "SELECT p.*, u.username, u.avatar,
                (SELECT COUNT(*) > 0 FROM likes WHERE post_id = p.id AND user_id = ?) as user_liked
                FROM posts p 
                JOIN users u ON p.user_id = u.id 
                ORDER BY p.created_at DESC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $posts = [];
        while ($row = $result->fetch_assoc()) {
            $posts[] = $row;
        }
        return $posts;
    }

    public function getByUser($user_id, $current_user_id = null) {
        $sql = "SELECT p.*, u.username, u.avatar,
                (SELECT COUNT(*) > 0 FROM likes WHERE post_id = p.id AND user_id = ?) as user_liked
                FROM posts p 
                JOIN users u ON p.user_id = u.id 
                WHERE p.user_id = ? 
                ORDER BY p.created_at DESC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $current_user_id, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $posts = [];
        while ($row = $result->fetch_assoc()) {
            $posts[] = $row;
        }
        return $posts;
    }

    public function getPostById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM posts WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function update($id, $user_id, $content) {
        $content = htmlspecialchars(strip_tags($content));
        $stmt = $this->conn->prepare("UPDATE posts SET content = ? WHERE id = ? AND user_id = ?");
        $stmt->bind_param("sii", $content, $id, $user_id);
        return $stmt->execute();
    }

    public function delete($id, $user_id) {
        $stmt = $this->conn->prepare("DELETE FROM posts WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $id, $user_id);
        return $stmt->execute();
    }

    public function updateLikesCount($post_id) {
        $stmt = $this->conn->prepare("UPDATE posts SET likes_count = (SELECT COUNT(*) FROM likes WHERE post_id = ?) WHERE id = ?");
        $stmt->bind_param("ii", $post_id, $post_id);
        return $stmt->execute();
    }

    public function updateCommentsCount($post_id) {
        $stmt = $this->conn->prepare("UPDATE posts SET comments_count = (SELECT COUNT(*) FROM comments WHERE post_id = ?) WHERE id = ?");
        $stmt->bind_param("ii", $post_id, $post_id);
        return $stmt->execute();
    }
}
?>