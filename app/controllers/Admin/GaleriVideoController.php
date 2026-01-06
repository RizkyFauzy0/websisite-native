<?php

class GaleriVideoController extends Controller {
    
    public function __construct() {
        $this->requireLogin();
        $this->galeriVideoModel = $this->model('GaleriVideoModel');
    }
    
    public function index() {
        $data = [
            'title' => 'Galeri Video',
            'active_menu' => 'galeri-video',
            'galeri_list' => $this->galeriVideoModel->getAll()
        ];
        
        $this->view('admin/galeri-video/index', $data);
    }
    
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Handle thumbnail upload (optional)
            $thumbnail = '';
            if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] == 0) {
                $upload = $this->uploadFile($_FILES['thumbnail'], 'uploads/galeri/');
                if ($upload['success']) {
                    $thumbnail = 'galeri/' . $upload['filename'];
                }
            }
            
            $data = [
                'judul' => htmlspecialchars($_POST['judul'] ?? ''),
                'deskripsi' => htmlspecialchars($_POST['deskripsi'] ?? ''),
                'url_video' => htmlspecialchars($_POST['url_video'] ?? ''),
                'thumbnail' => $thumbnail,
                'tanggal_upload' => $_POST['tanggal_upload'] ?? date('Y-m-d')
            ];
            
            if ($this->galeriVideoModel->create($data)) {
                $this->setFlash('success', 'Video berhasil ditambahkan');
            } else {
                $this->setFlash('error', 'Gagal menambahkan video');
            }
        }
        
        $this->redirect('admin/galeri-video');
    }
    
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $galeri = $this->galeriVideoModel->getById($id);
            
            if (!$galeri) {
                $this->setFlash('error', 'Video tidak ditemukan');
                $this->redirect('admin/galeri-video');
                return;
            }
            
            $data = [
                'judul' => htmlspecialchars($_POST['judul'] ?? ''),
                'deskripsi' => htmlspecialchars($_POST['deskripsi'] ?? ''),
                'url_video' => htmlspecialchars($_POST['url_video'] ?? ''),
                'tanggal_upload' => $_POST['tanggal_upload'] ?? date('Y-m-d')
            ];
            
            // Handle thumbnail upload if new file provided
            if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] == 0) {
                $upload = $this->uploadFile($_FILES['thumbnail'], 'uploads/galeri/');
                if ($upload['success']) {
                    // Delete old file
                    if (!empty($galeri->thumbnail)) {
                        $this->deleteFile($galeri->thumbnail, 'uploads/');
                    }
                    $data['thumbnail'] = 'galeri/' . $upload['filename'];
                }
            }
            
            if ($this->galeriVideoModel->update($id, $data)) {
                $this->setFlash('success', 'Video berhasil diperbarui');
            } else {
                $this->setFlash('error', 'Gagal memperbarui video');
            }
        }
        
        $this->redirect('admin/galeri-video');
    }
    
    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $galeri = $this->galeriVideoModel->getById($id);
            
            if ($galeri) {
                // Delete thumbnail file
                if (!empty($galeri->thumbnail)) {
                    $this->deleteFile($galeri->thumbnail, 'uploads/');
                }
                
                if ($this->galeriVideoModel->delete($id)) {
                    $this->setFlash('success', 'Video berhasil dihapus');
                } else {
                    $this->setFlash('error', 'Gagal menghapus video');
                }
            } else {
                $this->setFlash('error', 'Video tidak ditemukan');
            }
        }
        
        $this->redirect('admin/galeri-video');
    }
}
