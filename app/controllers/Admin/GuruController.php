<?php

class GuruController extends Controller {
    
    public function __construct() {
        $this->requireLogin();
        $this->guruModel = $this->model('GuruModel');
    }
    
    public function index() {
        $data = [
            'title' => 'Data Guru',
            'active_menu' => 'guru',
            'guru_list' => $this->guruModel->getAll()
        ];
        
        $this->view('admin/guru/index', $data);
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
                    $this->redirect('admin/guru');
                    return;
                }
            }
            
            $data = [
                'nama_guru' => htmlspecialchars($_POST['nama_guru'] ?? ''),
                'nip' => htmlspecialchars($_POST['nip'] ?? ''),
                'foto' => $foto,
                'mata_pelajaran' => htmlspecialchars($_POST['mata_pelajaran'] ?? ''),
                'pendidikan' => htmlspecialchars($_POST['pendidikan'] ?? ''),
                'email' => htmlspecialchars($_POST['email'] ?? ''),
                'no_telp' => htmlspecialchars($_POST['no_telp'] ?? ''),
                'status' => $_POST['status'] ?? 'aktif'
            ];
            
            if ($this->guruModel->create($data)) {
                $this->setFlash('success', 'Data guru berhasil ditambahkan');
            } else {
                $this->setFlash('error', 'Gagal menambahkan data guru');
            }
        }
        
        $this->redirect('admin/guru');
    }
    
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $guru = $this->guruModel->getById($id);
            
            if (!$guru) {
                $this->setFlash('error', 'Guru tidak ditemukan');
                $this->redirect('admin/guru');
                return;
            }
            
            $data = [
                'nama_guru' => htmlspecialchars($_POST['nama_guru'] ?? ''),
                'nip' => htmlspecialchars($_POST['nip'] ?? ''),
                'mata_pelajaran' => htmlspecialchars($_POST['mata_pelajaran'] ?? ''),
                'pendidikan' => htmlspecialchars($_POST['pendidikan'] ?? ''),
                'email' => htmlspecialchars($_POST['email'] ?? ''),
                'no_telp' => htmlspecialchars($_POST['no_telp'] ?? ''),
                'status' => $_POST['status'] ?? 'aktif'
            ];
            
            // Handle file upload if new file provided
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
                $upload = $this->uploadFile($_FILES['foto'], 'uploads/guru/');
                if ($upload['success']) {
                    // Delete old file
                    if (!empty($guru->foto)) {
                        $this->deleteFile($guru->foto, 'uploads/');
                    }
                    $data['foto'] = 'guru/' . $upload['filename'];
                }
            }
            
            if ($this->guruModel->update($id, $data)) {
                $this->setFlash('success', 'Data guru berhasil diperbarui');
            } else {
                $this->setFlash('error', 'Gagal memperbarui data guru');
            }
        }
        
        $this->redirect('admin/guru');
    }
    
    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $guru = $this->guruModel->getById($id);
            
            if ($guru) {
                // Delete file
                if (!empty($guru->foto)) {
                    $this->deleteFile($guru->foto, 'uploads/');
                }
                
                if ($this->guruModel->delete($id)) {
                    $this->setFlash('success', 'Data guru berhasil dihapus');
                } else {
                    $this->setFlash('error', 'Gagal menghapus data guru');
                }
            } else {
                $this->setFlash('error', 'Guru tidak ditemukan');
            }
        }
        
        $this->redirect('admin/guru');
    }
}
