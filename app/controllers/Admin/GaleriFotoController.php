<?php

class GaleriFotoController extends Controller {
    
    public function __construct() {
        $this->requireLogin();
        $this->galeriFotoModel = $this->model('GaleriFotoModel');
    }
    
    public function index() {
        $data = [
            'title' => 'Galeri Foto',
            'active_menu' => 'galeri-foto',
            'galeri_list' => $this->galeriFotoModel->getAll()
        ];
        
        $this->view('admin/galeri-foto/index', $data);
    }
    
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Handle file upload
            $gambar = '';
            if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
                $upload = $this->uploadFile($_FILES['gambar'], 'uploads/galeri/');
                if ($upload['success']) {
                    $gambar = 'galeri/' . $upload['filename'];
                } else {
                    $this->setFlash('error', $upload['message']);
                    $this->redirect('admin/galeri-foto');
                    return;
                }
            } else {
                $this->setFlash('error', 'Gambar wajib diunggah');
                $this->redirect('admin/galeri-foto');
                return;
            }
            
            $data = [
                'judul' => htmlspecialchars($_POST['judul'] ?? ''),
                'deskripsi' => htmlspecialchars($_POST['deskripsi'] ?? ''),
                'gambar' => $gambar,
                'tanggal_upload' => $_POST['tanggal_upload'] ?? date('Y-m-d')
            ];
            
            if ($this->galeriFotoModel->create($data)) {
                $this->setFlash('success', 'Foto berhasil ditambahkan');
            } else {
                $this->setFlash('error', 'Gagal menambahkan foto');
            }
        }
        
        $this->redirect('admin/galeri-foto');
    }
    
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $galeri = $this->galeriFotoModel->getById($id);
            
            if (!$galeri) {
                $this->setFlash('error', 'Foto tidak ditemukan');
                $this->redirect('admin/galeri-foto');
                return;
            }
            
            $data = [
                'judul' => htmlspecialchars($_POST['judul'] ?? ''),
                'deskripsi' => htmlspecialchars($_POST['deskripsi'] ?? ''),
                'tanggal_upload' => $_POST['tanggal_upload'] ?? date('Y-m-d')
            ];
            
            // Handle file upload if new file provided
            if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
                $upload = $this->uploadFile($_FILES['gambar'], 'uploads/galeri/');
                if ($upload['success']) {
                    // Delete old file
                    if (!empty($galeri->gambar)) {
                        $this->deleteFile($galeri->gambar, 'uploads/');
                    }
                    $data['gambar'] = 'galeri/' . $upload['filename'];
                }
            }
            
            if ($this->galeriFotoModel->update($id, $data)) {
                $this->setFlash('success', 'Foto berhasil diperbarui');
            } else {
                $this->setFlash('error', 'Gagal memperbarui foto');
            }
        }
        
        $this->redirect('admin/galeri-foto');
    }
    
    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $galeri = $this->galeriFotoModel->getById($id);
            
            if ($galeri) {
                // Delete file
                if (!empty($galeri->gambar)) {
                    $this->deleteFile($galeri->gambar, 'uploads/');
                }
                
                if ($this->galeriFotoModel->delete($id)) {
                    $this->setFlash('success', 'Foto berhasil dihapus');
                } else {
                    $this->setFlash('error', 'Gagal menghapus foto');
                }
            } else {
                $this->setFlash('error', 'Foto tidak ditemukan');
            }
        }
        
        $this->redirect('admin/galeri-foto');
    }
}
