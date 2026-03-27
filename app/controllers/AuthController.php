<?php
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../../config/database.php';

class AuthController {
    private $userModel;

    public function __construct() {
        $db = new Database();
        $this->userModel = new UserModel($db->connect());
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            
            $user = $this->userModel->login($username, $password);
            
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['avatar'] = $user['avatar'];
                $_SESSION['full_name'] = $user['full_name'];
                
                header('Location: /yanqr_system/public/feed');
                exit();
            } else {
                $error = "Invalid username or password";
                require_once __DIR__ . '/../views/auth/login.php';
            }
        } else {
            require_once __DIR__ . '/../views/auth/login.php';
        }
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $full_name = $_POST['full_name'] ?? '';
            $bio = $_POST['bio'] ?? '';
            
            if (strlen($password) < 4) {
                $error = "Password must be at least 4 characters";
            } else {
                $result = $this->userModel->register($username, $email, $password, $full_name, $bio);
                if ($result) {
                    header('Location: /yanqr_system/public/auth/login?registered=1');
                    exit();
                } else {
                    $error = "Username or email already exists";
                }
            }
            require_once __DIR__ . '/../views/auth/register.php';
        } else {
            require_once __DIR__ . '/../views/auth/register.php';
        }
    }

    public function logout() {
        session_destroy();
        header('Location: /yanqr_system/public/auth/login');
        exit();
    }
}
?>