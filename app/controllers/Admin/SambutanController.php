<?php

class SambutanController extends Controller {
    
    public function __construct() {
        $this->requireLogin();
        $this->sambutanModel = $this->model('SambutanModel');
    }
    
    public function index() {
        $data = [
            'title' => 'Sambutan Kepala Sekolah',
            'active_menu' => 'sambutan',
            'sambutan_list' => $this->sambutanModel->getAll()
        ];
        
        $this->view('admin/sambutan/index', $data);
    }
    
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Handle file upload
            $foto = '';
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
                $upload = $this->uploadFile($_FILES['foto'], 'uploads/guru/');
                if ($upload['success']) {
                    $foto = 'guru/' . $upload['filename'];
                } else {
                    $this->setFlash('error', $upload['message']);
                    $this->redirect('admin/sambutan');
                    return;
                }
            }
            
            $data = [
                'nama_kepsek' => htmlspecialchars($_POST['nama_kepsek'] ?? ''),
                'jabatan' => htmlspecialchars($_POST['jabatan'] ?? 'Kepala Sekolah'),
                'foto' => $foto,
                'isi_sambutan' => $_POST['isi_sambutan'] ?? ''
            ];
            
            if ($this->sambutanModel->create($data)) {
                $this->setFlash('success', 'Sambutan berhasil ditambahkan');
            } else {
                $this->setFlash('error', 'Gagal menambahkan sambutan');
            }
        }
        
        $this->redirect('admin/sambutan');
    }
    
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $sambutan = $this->sambutanModel->getById($id);
            
            if (!$sambutan) {
                $this->setFlash('error', 'Sambutan tidak ditemukan');
                $this->redirect('admin/sambutan');
                return;
            }
            
            $data = [
                'nama_kepsek' => htmlspecialchars($_POST['nama_kepsek'] ?? ''),
                'jabatan' => htmlspecialchars($_POST['jabatan'] ?? 'Kepala Sekolah'),
                'isi_sambutan' => $_POST['isi_sambutan'] ?? ''
            ];
            
            // Handle file upload if new file provided
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
                $upload = $this->uploadFile($_FILES['foto'], 'uploads/guru/');
                if ($upload['success']) {
                    // Delete old file
                    if (!empty($sambutan->foto)) {
                        $this->deleteFile($sambutan->foto, 'uploads/');
                    }
                    $data['foto'] = 'guru/' . $upload['filename'];
                }
            }
            
            if ($this->sambutanModel->update($id, $data)) {
                $this->setFlash('success', 'Sambutan berhasil diperbarui');
            } else {
                $this->setFlash('error', 'Gagal memperbarui sambutan');
            }
        }
        
        $this->redirect('admin/sambutan');
    }
    
    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $sambutan = $this->sambutanModel->getById($id);
            
            if ($sambutan) {
                // Delete file
                if (!empty($sambutan->foto)) {
                    $this->deleteFile($sambutan->foto, 'uploads/');
                }
                
                if ($this->sambutanModel->delete($id)) {
                    $this->setFlash('success', 'Sambutan berhasil dihapus');
                } else {
                    $this->setFlash('error', 'Gagal menghapus sambutan');
                }
            } else {
                $this->setFlash('error', 'Sambutan tidak ditemukan');
            }
        }
        
        $this->redirect('admin/sambutan');
    }
}
