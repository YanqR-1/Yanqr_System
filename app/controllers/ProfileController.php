<?php
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/PostModel.php';
require_once __DIR__ . '/../models/CommentModel.php';
require_once __DIR__ . '/../../config/database.php';

class ProfileController {
    private $userModel;
    private $postModel;
    private $commentModel;

    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /yanqr_system/public/auth/login');
            exit();
        }
        
        $db = new Database();
        $this->userModel = new UserModel($db->connect());
        $this->postModel = new PostModel($db->connect());
        $this->commentModel = new CommentModel($db->connect());
    }

    public function index() {
        $user = $this->userModel->getUserById($_SESSION['user_id']);
        $posts = $this->postModel->getByUser($_SESSION['user_id'], $_SESSION['user_id']);
        
        // Get comments for each post
        foreach ($posts as &$post) {
            $post['comments'] = $this->commentModel->getByPost($post['id']);
        }
        
        $is_owner = true;
        
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/profile/index.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }

    public function avatar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['avatar'])) {
            $file = $_FILES['avatar'];
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            
            if (in_array($ext, $allowed) && $file['size'] < 2000000) {
                $filename = 'avatar_' . $_SESSION['user_id'] . '_' . time() . '.' . $ext;
                $path = __DIR__ . '/../../public/assets/uploads/profiles/' . $filename;
                
                if (move_uploaded_file($file['tmp_name'], $path)) {
                    $this->userModel->updateAvatar($_SESSION['user_id'], $filename);
                    $_SESSION['avatar'] = $filename;
                }
            }
        }
        header('Location: /yanqr_system/public/profile');
        exit();
    }
}
?>