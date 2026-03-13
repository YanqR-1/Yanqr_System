<?php
require_once 'C:\\Xampp\\htdocs\\yanqr_system\\app\\models\\UserModel.php';
require_once 'C:\\Xampp\\htdocs\\yanqr_system\\config\\database.php';

class AuthController {
    private $userModel;
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->userModel = new UserModel($this->db);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            
            $result = $this->userModel->login($username, $password);
            
            if ($result['success']) {
                $_SESSION['user_id'] = $result['user']['id'];
                $_SESSION['username'] = $result['user']['username'];
                $_SESSION['full_name'] = $result['user']['full_name'];
                $_SESSION['profile_image'] = $result['user']['profile_image'];
                
                header('Location: /yanqr_system/public/feed');
                exit();
            } else {
                $error = $result['error'];
                require_once 'C:\\Xampp\\htdocs\\yanqr_system\\app\\views\\auth\\login.php';
            }
        } else {
            require_once 'C:\\Xampp\\htdocs\\yanqr_system\\app\\views\\auth\\login.php';
        }
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'username' => $_POST['username'] ?? '',
                'email' => $_POST['email'] ?? '',
                'password' => $_POST['password'] ?? '',
                'full_name' => $_POST['full_name'] ?? '',
                'bio' => $_POST['bio'] ?? '',
                'location' => $_POST['location'] ?? '',
                'website' => $_POST['website'] ?? '',
                'favorite_game' => $_POST['favorite_game'] ?? ''
            ];
            
            $errors = [];
            if (empty($data['username'])) $errors[] = "Username is required";
            if (empty($data['email'])) $errors[] = "Email is required";
            if (empty($data['password'])) $errors[] = "Password is required";
            if (strlen($data['password']) < 6) $errors[] = "Password must be at least 6 characters";
            if (empty($data['full_name'])) $errors[] = "Full name is required";
            
            if (empty($errors)) {
                $result = $this->userModel->register($data);
                
                if ($result['success']) {
                    header('Location: /yanqr_system/public/auth/login?registered=1');
                    exit();
                } else {
                    $error = $result['error'];
                }
            }
            
            require_once 'C:\\Xampp\\htdocs\\yanqr_system\\app\\views\\auth\\register.php';
        } else {
            require_once 'C:\\Xampp\\htdocs\\yanqr_system\\app\\views\\auth\\register.php';
        }
    }

    public function logout() {
        session_destroy();
        header('Location: /yanqr_system/public/auth/login');
        exit();
    }
}
?>