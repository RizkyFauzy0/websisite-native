<?php

class UserController extends Controller {
    
    public function __construct() {
        $this->requireLogin();
        $this->userModel = $this->model('UserModel');
    }
    
    public function index() {
        $data = [
            'title' => 'Manajemen User',
            'active_menu' => 'user',
            'user_list' => $this->userModel->getAll()
        ];
        
        $this->view('admin/user/index', $data);
    }
    
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Validate input
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $password_confirm = $_POST['password_confirm'] ?? '';
            
            if (empty($username) || empty($password)) {
                $this->setFlash('error', 'Username dan password wajib diisi');
                $this->redirect('admin/user');
                return;
            }
            
            if ($password !== $password_confirm) {
                $this->setFlash('error', 'Password dan konfirmasi password tidak cocok');
                $this->redirect('admin/user');
                return;
            }
            
            // Check if username exists
            if ($this->userModel->usernameExists($username)) {
                $this->setFlash('error', 'Username sudah digunakan');
                $this->redirect('admin/user');
                return;
            }
            
            $data = [
                'username' => htmlspecialchars($username),
                'password' => $password,
                'nama_lengkap' => htmlspecialchars($_POST['nama_lengkap'] ?? ''),
                'email' => htmlspecialchars($_POST['email'] ?? '')
            ];
            
            if ($this->userModel->create($data)) {
                $this->setFlash('success', 'User berhasil ditambahkan');
            } else {
                $this->setFlash('error', 'Gagal menambahkan user');
            }
        }
        
        $this->redirect('admin/user');
    }
    
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user = $this->userModel->getById($id);
            
            if (!$user) {
                $this->setFlash('error', 'User tidak ditemukan');
                $this->redirect('admin/user');
                return;
            }
            
            // Validate input
            $username = $_POST['username'] ?? '';
            
            if (empty($username)) {
                $this->setFlash('error', 'Username wajib diisi');
                $this->redirect('admin/user');
                return;
            }
            
            // Check if username exists (exclude current user)
            if ($this->userModel->usernameExists($username, $id)) {
                $this->setFlash('error', 'Username sudah digunakan');
                $this->redirect('admin/user');
                return;
            }
            
            $data = [
                'username' => htmlspecialchars($username),
                'nama_lengkap' => htmlspecialchars($_POST['nama_lengkap'] ?? ''),
                'email' => htmlspecialchars($_POST['email'] ?? '')
            ];
            
            // Only update password if provided
            $password = $_POST['password'] ?? '';
            $password_confirm = $_POST['password_confirm'] ?? '';
            
            if (!empty($password)) {
                if ($password !== $password_confirm) {
                    $this->setFlash('error', 'Password dan konfirmasi password tidak cocok');
                    $this->redirect('admin/user');
                    return;
                }
                $data['password'] = $password;
            }
            
            if ($this->userModel->update($id, $data)) {
                $this->setFlash('success', 'User berhasil diperbarui');
            } else {
                $this->setFlash('error', 'Gagal memperbarui user');
            }
        }
        
        $this->redirect('admin/user');
    }
    
    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Prevent deleting current user
            if ($id == $_SESSION['admin_id']) {
                $this->setFlash('error', 'Tidak dapat menghapus user yang sedang login');
                $this->redirect('admin/user');
                return;
            }
            
            if ($this->userModel->delete($id)) {
                $this->setFlash('success', 'User berhasil dihapus');
            } else {
                $this->setFlash('error', 'Gagal menghapus user');
            }
        }
        
        $this->redirect('admin/user');
    }
}
