<?php

class PengumumanController extends Controller {
    
    public function __construct() {
        $this->requireLogin();
        $this->pengumumanModel = $this->model('PengumumanModel');
    }
    
    public function index() {
        $data = [
            'title' => 'Manajemen Pengumuman',
            'active_menu' => 'pengumuman',
            'pengumuman_list' => $this->pengumumanModel->getAll()
        ];
        
        $this->view('admin/pengumuman/index', $data);
    }
    
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'judul' => htmlspecialchars($_POST['judul'] ?? ''),
                'isi_pengumuman' => $_POST['isi_pengumuman'] ?? '',
                'tanggal_mulai' => $_POST['tanggal_mulai'] ?? date('Y-m-d'),
                'tanggal_selesai' => $_POST['tanggal_selesai'] ?? null,
                'status' => $_POST['status'] ?? 'aktif'
            ];
            
            if ($this->pengumumanModel->create($data)) {
                $this->setFlash('success', 'Pengumuman berhasil ditambahkan');
            } else {
                $this->setFlash('error', 'Gagal menambahkan pengumuman');
            }
        }
        
        $this->redirect('admin/pengumuman');
    }
    
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'judul' => htmlspecialchars($_POST['judul'] ?? ''),
                'isi_pengumuman' => $_POST['isi_pengumuman'] ?? '',
                'tanggal_mulai' => $_POST['tanggal_mulai'] ?? date('Y-m-d'),
                'tanggal_selesai' => $_POST['tanggal_selesai'] ?? null,
                'status' => $_POST['status'] ?? 'aktif'
            ];
            
            if ($this->pengumumanModel->update($id, $data)) {
                $this->setFlash('success', 'Pengumuman berhasil diperbarui');
            } else {
                $this->setFlash('error', 'Gagal memperbarui pengumuman');
            }
        }
        
        $this->redirect('admin/pengumuman');
    }
    
    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->pengumumanModel->delete($id)) {
                $this->setFlash('success', 'Pengumuman berhasil dihapus');
            } else {
                $this->setFlash('error', 'Gagal menghapus pengumuman');
            }
        }
        
        $this->redirect('admin/pengumuman');
    }
}
