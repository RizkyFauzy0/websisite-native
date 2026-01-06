<?php

class PrestasiController extends Controller {
    
    public function __construct() {
        $this->requireLogin();
        $this->prestasiModel = $this->model('PrestasiModel');
    }
    
    public function index() {
        $data = [
            'title' => 'Prestasi',
            'active_menu' => 'prestasi',
            'prestasi_list' => $this->prestasiModel->getAll()
        ];
        
        $this->view('admin/prestasi/index', $data);
    }
    
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Handle file upload
            $gambar = '';
            if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
                $upload = $this->uploadFile($_FILES['gambar'], 'uploads/prestasi/');
                if ($upload['success']) {
                    $gambar = 'prestasi/' . $upload['filename'];
                }
            }
            
            $data = [
                'jenis' => $_POST['jenis'] ?? 'siswa',
                'judul' => htmlspecialchars($_POST['judul'] ?? ''),
                'deskripsi' => htmlspecialchars($_POST['deskripsi'] ?? ''),
                'tingkat' => htmlspecialchars($_POST['tingkat'] ?? ''),
                'tahun' => htmlspecialchars($_POST['tahun'] ?? date('Y')),
                'gambar' => $gambar
            ];
            
            if ($this->prestasiModel->create($data)) {
                $this->setFlash('success', 'Prestasi berhasil ditambahkan');
            } else {
                $this->setFlash('error', 'Gagal menambahkan prestasi');
            }
        }
        
        $this->redirect('admin/prestasi');
    }
    
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $prestasi = $this->prestasiModel->getById($id);
            
            if (!$prestasi) {
                $this->setFlash('error', 'Prestasi tidak ditemukan');
                $this->redirect('admin/prestasi');
                return;
            }
            
            $data = [
                'jenis' => $_POST['jenis'] ?? 'siswa',
                'judul' => htmlspecialchars($_POST['judul'] ?? ''),
                'deskripsi' => htmlspecialchars($_POST['deskripsi'] ?? ''),
                'tingkat' => htmlspecialchars($_POST['tingkat'] ?? ''),
                'tahun' => htmlspecialchars($_POST['tahun'] ?? date('Y'))
            ];
            
            // Handle file upload if new file provided
            if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
                $upload = $this->uploadFile($_FILES['gambar'], 'uploads/prestasi/');
                if ($upload['success']) {
                    // Delete old file
                    if (!empty($prestasi->gambar)) {
                        $this->deleteFile($prestasi->gambar, 'uploads/');
                    }
                    $data['gambar'] = 'prestasi/' . $upload['filename'];
                }
            }
            
            if ($this->prestasiModel->update($id, $data)) {
                $this->setFlash('success', 'Prestasi berhasil diperbarui');
            } else {
                $this->setFlash('error', 'Gagal memperbarui prestasi');
            }
        }
        
        $this->redirect('admin/prestasi');
    }
    
    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $prestasi = $this->prestasiModel->getById($id);
            
            if ($prestasi) {
                // Delete file
                if (!empty($prestasi->gambar)) {
                    $this->deleteFile($prestasi->gambar, 'uploads/');
                }
                
                if ($this->prestasiModel->delete($id)) {
                    $this->setFlash('success', 'Prestasi berhasil dihapus');
                } else {
                    $this->setFlash('error', 'Gagal menghapus prestasi');
                }
            } else {
                $this->setFlash('error', 'Prestasi tidak ditemukan');
            }
        }
        
        $this->redirect('admin/prestasi');
    }
}
