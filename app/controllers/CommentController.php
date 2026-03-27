<?php
require_once __DIR__ . '/../models/CommentModel.php';
require_once __DIR__ . '/../../config/database.php';

class CommentController {
    private $commentModel;

    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /yanqr_system/public/auth/login');
            exit();
        }
        
        $db = new Database();
        $this->commentModel = new CommentModel($db->connect());
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post_id = isset($_POST['post_id']) ? (int)$_POST['post_id'] : 0;
            $content = isset($_POST['content']) ? trim($_POST['content']) : '';
            
            if (!empty($content) && $post_id > 0) {
                $this->commentModel->create($post_id, $_SESSION['user_id'], $content);
            }
        }
        
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    public function delete($id = null) {
        if ($id === null && isset($_POST['id'])) {
            $id = (int)$_POST['id'];
        }
        
        if ($id && $_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->commentModel->delete($id, $_SESSION['user_id']);
        }
        
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
}
?>