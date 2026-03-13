<?php
require_once 'C:\\Xampp\\htdocs\\yanqr_system\\app\\models\\LikeModel.php';
require_once 'C:\\Xampp\\htdocs\\yanqr_system\\config\\database.php';

class LikeController {
    private $likeModel;
    private $db;

    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /yanqr_system/public/auth/login');
            exit();
        }
        
        $database = new Database();
        $this->db = $database->connect();
        $this->likeModel = new LikeModel($this->db);
    }

    public function toggle() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post_id = $_POST['post_id'] ?? 0;
            
            $result = $this->likeModel->toggleLike($post_id, $_SESSION['user_id']);
            
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                header('Content-Type: application/json');
                echo json_encode($result);
                exit();
            }
        }
        
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
}
?>