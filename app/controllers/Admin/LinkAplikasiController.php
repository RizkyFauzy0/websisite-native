<?php

class LinkAplikasiController extends Controller {
    
    public function __construct() {
        $this->requireLogin();
        $this->linkAplikasiModel = $this->model('LinkAplikasiModel');
    }
    
    public function index() {
        $data = [
            'title' => 'Link Aplikasi',
            'active_menu' => 'link-aplikasi',
            'link_list' => $this->linkAplikasiModel->getAll()
        ];
        
        $this->view('admin/link-aplikasi/index', $data);
    }
    
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Handle icon upload (optional)
            $icon = '';
            if (isset($_FILES['icon']) && $_FILES['icon']['error'] == 0) {
                $upload = $this->uploadFile($_FILES['icon'], 'uploads/logo/');
                if ($upload['success']) {
                    $icon = 'logo/' . $upload['filename'];
                }
            }
            
            $data = [
                'nama_aplikasi' => htmlspecialchars($_POST['nama_aplikasi'] ?? ''),
                'deskripsi' => htmlspecialchars($_POST['deskripsi'] ?? ''),
                'url' => htmlspecialchars($_POST['url'] ?? ''),
                'icon' => $icon,
                'urutan' => (int)($_POST['urutan'] ?? 0),
                'status' => $_POST['status'] ?? 'aktif'
            ];
            
            if ($this->linkAplikasiModel->create($data)) {
                $this->setFlash('success', 'Link aplikasi berhasil ditambahkan');
            } else {
                $this->setFlash('error', 'Gagal menambahkan link aplikasi');
            }
        }
        
        $this->redirect('admin/link-aplikasi');
    }
    
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $link = $this->linkAplikasiModel->getById($id);
            
            if (!$link) {
                $this->setFlash('error', 'Link tidak ditemukan');
                $this->redirect('admin/link-aplikasi');
                return;
            }
            
            $data = [
                'nama_aplikasi' => htmlspecialchars($_POST['nama_aplikasi'] ?? ''),
                'deskripsi' => htmlspecialchars($_POST['deskripsi'] ?? ''),
                'url' => htmlspecialchars($_POST['url'] ?? ''),
                'urutan' => (int)($_POST['urutan'] ?? 0),
                'status' => $_POST['status'] ?? 'aktif'
            ];
            
            // Handle icon upload if new file provided
            if (isset($_FILES['icon']) && $_FILES['icon']['error'] == 0) {
                $upload = $this->uploadFile($_FILES['icon'], 'uploads/logo/');
                if ($upload['success']) {
                    // Delete old file
                    if (!empty($link->icon)) {
                        $this->deleteFile($link->icon, 'uploads/');
                    }
                    $data['icon'] = 'logo/' . $upload['filename'];
                }
            }
            
            if ($this->linkAplikasiModel->update($id, $data)) {
                $this->setFlash('success', 'Link aplikasi berhasil diperbarui');
            } else {
                $this->setFlash('error', 'Gagal memperbarui link aplikasi');
            }
        }
        
        $this->redirect('admin/link-aplikasi');
    }
    
    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $link = $this->linkAplikasiModel->getById($id);
            
            if ($link) {
                // Delete icon file
                if (!empty($link->icon)) {
                    $this->deleteFile($link->icon, 'uploads/');
                }
                
                if ($this->linkAplikasiModel->delete($id)) {
                    $this->setFlash('success', 'Link aplikasi berhasil dihapus');
                } else {
                    $this->setFlash('error', 'Gagal menghapus link aplikasi');
                }
            } else {
                $this->setFlash('error', 'Link tidak ditemukan');
            }
        }
        
        $this->redirect('admin/link-aplikasi');
    }
}
