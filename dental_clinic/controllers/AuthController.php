<?php
require_once '../core/Controller.php';

class AuthController extends Controller {
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCSRF();
            
            $username = $_POST['username'];
            $password = $_POST['password'];

            $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['full_name'] = $user['full_name'];
                
                $this->redirect('/dashboard');
            } else {
                $error = "Invalid username or password";
                $this->view('auth/login', ['error' => $error, 'csrf_token' => $this->generateCSRFToken()]);
            }
        } else {
            $this->view('auth/login', ['csrf_token' => $this->generateCSRFToken()]);
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        $this->redirect('/login');
    }

    public function unauthorized() {
        $this->view('errors/unauthorized');
    }
}