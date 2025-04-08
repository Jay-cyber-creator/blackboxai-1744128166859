<?php
abstract class Controller {
    protected $db;
    protected $viewPath = '../views/';
    
    public function __construct() {
        require_once '../config/database.php';
        $this->db = Database::connect();
    }

    protected function view($view, $data = []) {
        extract($data);
        require $this->viewPath . $view . '.php';
    }

    protected function redirect($url) {
        header('Location: ' . $url);
        exit();
    }

    protected function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    protected function isAdmin() {
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
    }

    protected function validateCSRF() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                die('CSRF token validation failed');
            }
        }
    }

    protected function generateCSRFToken() {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
}