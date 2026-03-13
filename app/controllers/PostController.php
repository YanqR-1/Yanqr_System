<?php
require_once 'C:\\Xampp\\htdocs\\yanqr_system\\app\\models\\PostModel.php';
require_once 'C:\\Xampp\\htdocs\\yanqr_system\\app\\models\\UserModel.php';
require_once 'C:\\Xampp\\htdocs\\yanqr_system\\config\\database.php';

class PostController {
    private $postModel;
    private $userModel;
    private $db;

    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /yanqr_system/public/auth/login');
            exit();
        }
        
        $database = new Database();
        $this->db = $database->connect();
        $this->postModel = new PostModel($this->db);
        $this->userModel = new UserModel($this->db);
    }

    public function index() {
        $user_id = $_SESSION['user_id'];
        $posts = $this->postModel->getAllPosts($user_id);
        $suggested_users = $this->userModel->searchUsers('');
        
        require_once 'C:\\Xampp\\htdocs\\yanqr_system\\app\\views\\layouts\\header.php';
        require_once 'C:\\Xampp\\htdocs\\yanqr_system\\app\\views\\posts\\feed.php';
        require_once 'C:\\Xampp\\htdocs\\yanqr_system\\app\\views\\layouts\\footer.php';
    }

    public function feed() {
        $this->index();
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'content' => $_POST['content'] ?? '',
                'game_tag' => $_POST['game_tag'] ?? ''
            ];
            
            // Handle image upload
            $image = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $allowed = ['jpg', 'jpeg', 'png', 'gif'];
                $filename = $_FILES['image']['name'];
                $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                
                if (in_array($ext, $allowed)) {
                    $new_filename = 'post_' . $_SESSION['user_id'] . '_' . time() . '.' . $ext;
                    $upload_path = 'C:\\Xampp\\htdocs\\yanqr_system\\public\\assets\\uploads\\posts\\' . $new_filename;
                    
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                        $image = $new_filename;
                    }
                }
            }
            
            $data['image'] = $image;
            
            $result = $this->postModel->create($_SESSION['user_id'], $data);
            
            if ($result['success']) {
                header('Location: /yanqr_system/public/feed');
                exit();
            } else {
                $error = $result['error'];
            }
        }
        
        require_once 'C:\\Xampp\\htdocs\\yanqr_system\\app\\views\\layouts\\header.php';
        require_once 'C:\\Xampp\\htdocs\\yanqr_system\\app\\views\\posts\\create.php';
        require_once 'C:\\Xampp\\htdocs\\yanqr_system\\app\\views\\layouts\\footer.php';
    }

    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = $this->postModel->getPostById($id);
            
            if ($post && $post['user_id'] == $_SESSION['user_id']) {
                $this->postModel->delete($id, $_SESSION['user_id']);
            }
        }
        
        header('Location: /yanqr_system/public/feed');
        exit();
    }

    public function search() {
        $keyword = $_GET['q'] ?? '';
        $posts = $this->postModel->searchPosts($keyword);
        $users = $this->userModel->searchUsers($keyword);
        
        require_once 'C:\\Xampp\\htdocs\\yanqr_system\\app\\views\\layouts\\header.php';
        require_once 'C:\\Xampp\\htdocs\\yanqr_system\\app\\views\\posts\\feed.php';
        require_once 'C:\\Xampp\\htdocs\\yanqr_system\\app\\views\\layouts\\footer.php';
    }
}
?>