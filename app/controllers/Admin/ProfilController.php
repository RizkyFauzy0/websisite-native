<?php

class ProfilController extends Controller {
    
    public function __construct() {
        $this->requireLogin();
        $this->profilModel = $this->model('ProfilModel');
    }
    
    public function index() {
        $data = [
            'title' => 'Profil Sekolah',
            'active_menu' => 'profil',
            'profil_list' => $this->profilModel->getAll()
        ];
        
        $this->view('admin/profil/index', $data);
    }
    
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Handle file upload
            $gambar = null;
            if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
                $upload = $this->uploadFile($_FILES['gambar'], 'uploads/profil/');
                if ($upload['success']) {
                    $gambar = 'profil/' . $upload['filename'];
                }
            }
            
            $data = [
                'jenis' => $_POST['jenis'] ?? '',
                'judul' => htmlspecialchars($_POST['judul'] ?? ''),
                'isi_konten' => $_POST['isi_konten'] ?? '',
                'gambar' => $gambar
            ];
            
            if ($this->profilModel->createOrUpdate($data)) {
                $this->setFlash('success', 'Profil berhasil disimpan');
            } else {
                $this->setFlash('error', 'Gagal menyimpan profil');
            }
        }
        
        $this->redirect('admin/profil');
    }
    
    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $profil = $this->profilModel->getById($id);
            
            if ($profil) {
                // Delete file
                if (!empty($profil->gambar)) {
                    $this->deleteFile($profil->gambar, 'uploads/');
                }
                
                if ($this->profilModel->delete($id)) {
                    $this->setFlash('success', 'Profil berhasil dihapus');
                } else {
                    $this->setFlash('error', 'Gagal menghapus profil');
                }
            } else {
                $this->setFlash('error', 'Profil tidak ditemukan');
            }
        }
        
        $this->redirect('admin/profil');
    }
}
