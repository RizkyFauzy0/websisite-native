<?php

class Controller {
    // Load model
    public function model($model) {
        // Prevent directory traversal
        $model = str_replace(['..', '\\', '/'], '', $model);
        
        require_once '../app/models/' . $model . '.php';
        return new $model();
    }
    
    // Load view
    public function view($view, $data = []) {
        // Prevent directory traversal
        $view = str_replace(['..', '\\'], '', $view);
        
        if (file_exists('../app/views/' . $view . '.php')) {
            extract($data);
            require_once '../app/views/' . $view . '.php';
        } else {
            die('View does not exist: ' . $view);
        }
    }
    
    // Redirect helper
    public function redirect($url) {
        header('Location: ' . BASE_URL . '/' . $url);
        exit;
    }
    
    // Check if user is logged in (admin)
    public function isLoggedIn() {
        return isset($_SESSION['admin_id']);
    }
    
    // Require login
    public function requireLogin() {
        if (!$this->isLoggedIn()) {
            $this->redirect('admin/login');
        }
    }
    
    // Flash message helper
    public function setFlash($type, $message) {
        $_SESSION['flash'] = [
            'type' => $type,
            'message' => $message
        ];
    }
    
    public function getFlash() {
        if (isset($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            unset($_SESSION['flash']);
            return $flash;
        }
        return null;
    }
    
    // Upload file helper
    public function uploadFile($file, $targetDir = 'uploads/') {
        $targetDir = '../public/' . $targetDir;
        
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        
        $fileName = time() . '_' . basename($file['name']);
        $targetFile = $targetDir . $fileName;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        
        // Check if file is an actual image
        $check = getimagesize($file['tmp_name']);
        if ($check === false) {
            return ['success' => false, 'message' => 'File is not an image.'];
        }
        
        // Check file size (5MB max)
        if ($file['size'] > 5000000) {
            return ['success' => false, 'message' => 'File is too large (max 5MB).'];
        }
        
        // Allow certain file formats
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowedTypes)) {
            return ['success' => false, 'message' => 'Only JPG, JPEG, PNG & GIF files are allowed.'];
        }
        
        // Upload file
        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            return ['success' => true, 'filename' => $fileName];
        } else {
            return ['success' => false, 'message' => 'Error uploading file.'];
        }
    }
    
    // Delete file helper
    public function deleteFile($filename, $targetDir = 'uploads/') {
        $filePath = '../public/' . $targetDir . $filename;
        if (file_exists($filePath)) {
            unlink($filePath);
            return true;
        }
        return false;
    }
}
