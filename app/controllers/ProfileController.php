<?php
require_once 'C:\\Xampp\\htdocs\\yanqr_system\\app\\models\\UserModel.php';
require_once 'C:\\Xampp\\htdocs\\yanqr_system\\app\\models\\PostModel.php';
require_once 'C:\\Xampp\\htdocs\\yanqr_system\\config\\database.php';

class ProfileController {
    private $userModel;
    private $postModel;
    private $db;

    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /yanqr_system/public/auth/login');
            exit();
        }
        
        $database = new Database();
        $this->db = $database->connect();
        $this->userModel = new UserModel($this->db);
        $this->postModel = new PostModel($this->db);
    }

    public function index($username = null) {
        if ($username) {
            $users = $this->userModel->searchUsers($username);
            $user = !empty($users) ? $users[0] : null;
            
            if (!$user) {
                header('Location: /yanqr_system/public/feed');
                exit();
            }
            
            $user = $this->userModel->getUserById($user['id']);
            $posts = $this->postModel->getPostsByUser($user['id'], $_SESSION['user_id']);
            $is_owner = ($user['id'] == $_SESSION['user_id']);
        } else {
            $user = $this->userModel->getUserById($_SESSION['user_id']);
            $posts = $this->postModel->getPostsByUser($_SESSION['user_id'], $_SESSION['user_id']);
            $is_owner = true;
        }
        
        require_once 'C:\\Xampp\\htdocs\\yanqr_system\\app\\views\\layouts\\header.php';
        require_once 'C:\\Xampp\\htdocs\\yanqr_system\\app\\views\\profile\\index.php';
        require_once 'C:\\Xampp\\htdocs\\yanqr_system\\app\\views\\layouts\\footer.php';
    }

    public function edit() {
        $user = $this->userModel->getUserById($_SESSION['user_id']);
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'full_name' => $_POST['full_name'] ?? '',
                'bio' => $_POST['bio'] ?? '',
                'location' => $_POST['location'] ?? '',
                'website' => $_POST['website'] ?? '',
                'favorite_game' => $_POST['favorite_game'] ?? ''
            ];
            
            // Handle profile image upload - FIXED
            if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
                $allowed = ['jpg', 'jpeg', 'png', 'gif'];
                $filename = $_FILES['profile_image']['name'];
                $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                
                if (in_array($ext, $allowed)) {
                    // Create unique filename
                    $new_filename = 'profile_' . $_SESSION['user_id'] . '_' . time() . '.' . $ext;
                    $upload_path = 'C:\\Xampp\\htdocs\\yanqr_system\\public\\assets\\uploads\\profiles\\' . $new_filename;
                    
                    if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $upload_path)) {
                        $data['profile_image'] = $new_filename;
                        $_SESSION['profile_image'] = $new_filename;
                    }
                }
            }
            
            // Handle cover image upload
            if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] == 0) {
                $allowed = ['jpg', 'jpeg', 'png', 'gif'];
                $filename = $_FILES['cover_image']['name'];
                $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                
                if (in_array($ext, $allowed)) {
                    $new_filename = 'cover_' . $_SESSION['user_id'] . '_' . time() . '.' . $ext;
                    $upload_path = 'C:\\Xampp\\htdocs\\yanqr_system\\public\\assets\\uploads\\profiles\\' . $new_filename;
                    
                    if (move_uploaded_file($_FILES['cover_image']['tmp_name'], $upload_path)) {
                        $data['cover_image'] = $new_filename;
                    }
                }
            }
            
            if ($this->userModel->updateProfile($_SESSION['user_id'], $data)) {
                $_SESSION['full_name'] = $data['full_name'];
                $success = "Profile updated successfully!";
                $user = $this->userModel->getUserById($_SESSION['user_id']);
            } else {
                $error = "Failed to update profile";
            }
        }
        
        require_once 'C:\\Xampp\\htdocs\\yanqr_system\\app\\views\\layouts\\header.php';
        require_once 'C:\\Xampp\\htdocs\\yanqr_system\\app\\views\\profile\\edit.php';
        require_once 'C:\\Xampp\\htdocs\\yanqr_system\\app\\views\\layouts\\footer.php';
    }
}
?>