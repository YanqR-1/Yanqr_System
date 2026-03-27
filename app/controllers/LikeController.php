<?php
require_once __DIR__ . '/../models/LikeModel.php';
require_once __DIR__ . '/../../config/database.php';

class LikeController {
    private $likeModel;

    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /yanqr_system/public/auth/login');
            exit();
        }
        
        $db = new Database();
        $this->likeModel = new LikeModel($db->connect());
    }

    public function toggle() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post_id = isset($_POST['post_id']) ? (int)$_POST['post_id'] : 0;
            
            if ($post_id > 0) {
                $result = $this->likeModel->toggle($post_id, $_SESSION['user_id']);
                
                // Check if AJAX request
                if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                    header('Content-Type: application/json');
                    echo json_encode($result);
                    exit();
                }
            }
        }
        
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
}
?>