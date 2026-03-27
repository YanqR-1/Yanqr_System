<?php
require_once __DIR__ . '/../models/PostModel.php';
require_once __DIR__ . '/../models/CommentModel.php';
require_once __DIR__ . '/../../config/database.php';

class PostController {
    private $postModel;
    private $commentModel;

    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /yanqr_system/public/auth/login');
            exit();
        }
        
        $db = new Database();
        $this->postModel = new PostModel($db->connect());
        $this->commentModel = new CommentModel($db->connect());
    }

    public function index() {
        $posts = $this->postModel->getAll($_SESSION['user_id']);
        
        // Get comments for each post
        foreach ($posts as &$post) {
            $post['comments'] = $this->commentModel->getByPost($post['id']);
        }
        
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/posts/feed.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $content = $_POST['content'] ?? '';
            if (!empty($content)) {
                $this->postModel->create($_SESSION['user_id'], $content);
            }
            header('Location: /yanqr_system/public/feed');
            exit();
        }
    }

    // Show edit form
    public function edit($id) {
        $post = $this->postModel->getPostById($id);
        
        // Check if post exists and user owns it
        if (!$post || $post['user_id'] != $_SESSION['user_id']) {
            header('Location: /yanqr_system/public/feed');
            exit();
        }
        
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/posts/edit.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }

    // Update post
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $content = $_POST['content'] ?? '';
            
            if (!empty($content)) {
                $this->postModel->update($id, $_SESSION['user_id'], $content);
            }
        }
        
        header('Location: /yanqr_system/public/feed');
        exit();
    }

    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->postModel->delete($id, $_SESSION['user_id']);
        }
        header('Location: /yanqr_system/public/feed');
        exit();
    }
}
?>