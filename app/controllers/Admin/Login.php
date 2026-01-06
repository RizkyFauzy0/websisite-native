<?php

class Login extends Controller {
    
    public function __construct() {
        $this->userModel = $this->model('UserModel');
    }
    
    public function index() {
        // If already logged in, redirect to dashboard
        if ($this->isLoggedIn()) {
            $this->redirect('admin/dashboard');
        }
        
        $data = [
            'title' => 'Login Admin'
        ];
        
        $this->view('admin/login', $data);
    }
    
    public function auth() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            
            if (empty($username) || empty($password)) {
                $this->setFlash('error', 'Username dan password harus diisi');
                $this->redirect('admin/login');
                return;
            }
            
            $user = $this->userModel->login($username, $password);
            
            if ($user) {
                $_SESSION['admin_id'] = $user->id;
                $_SESSION['admin_username'] = $user->username;
                $_SESSION['admin_nama'] = $user->nama_lengkap;
                
                $this->redirect('admin/dashboard');
            } else {
                $this->setFlash('error', 'Username atau password salah');
                $this->redirect('admin/login');
            }
        } else {
            $this->redirect('admin/login');
        }
    }
    
    public function logout() {
        unset($_SESSION['admin_id']);
        unset($_SESSION['admin_username']);
        unset($_SESSION['admin_nama']);
        session_destroy();
        
        $this->redirect('admin/login');
    }
}
