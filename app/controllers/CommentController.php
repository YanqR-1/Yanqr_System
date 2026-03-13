<?php
require_once 'C:\\Xampp\\htdocs\\yanqr_system\\app\\models\\CommentModel.php';
require_once 'C:\\Xampp\\htdocs\\yanqr_system\\config\\database.php';

class CommentController {
    private $commentModel;
    private $db;

    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /yanqr_system/public/auth/login');
            exit();
        }
        
        $database = new Database();
        $this->db = $database->connect();
        $this->commentModel = new CommentModel($this->db);
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post_id = $_POST['post_id'] ?? 0;
            $content = $_POST['content'] ?? '';
            
            if (!empty($content)) {
                $this->commentModel->create($post_id, $_SESSION['user_id'], $content);
            }
        }
        
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $comment = $this->commentModel->getCommentById($id);
            
            if ($comment && $comment['user_id'] == $_SESSION['user_id']) {
                $this->commentModel->delete($id, $_SESSION['user_id']);
            }
        }
        
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
}
?>