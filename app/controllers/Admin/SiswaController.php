<?php

class SiswaController extends Controller {
    
    public function __construct() {
        $this->requireLogin();
        $this->siswaModel = $this->model('SiswaModel');
    }
    
    public function index() {
        $data = [
            'title' => 'Data Siswa',
            'active_menu' => 'siswa',
            'siswa_list' => $this->siswaModel->getAll()
        ];
        
        $this->view('admin/siswa/index', $data);
    }
    
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'tingkat' => htmlspecialchars($_POST['tingkat'] ?? ''),
                'jumlah_siswa' => (int)($_POST['jumlah_siswa'] ?? 0),
                'tahun_ajaran' => htmlspecialchars($_POST['tahun_ajaran'] ?? '')
            ];
            
            if ($this->siswaModel->create($data)) {
                $this->setFlash('success', 'Data siswa berhasil ditambahkan');
            } else {
                $this->setFlash('error', 'Gagal menambahkan data siswa');
            }
        }
        
        $this->redirect('admin/siswa');
    }
    
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'tingkat' => htmlspecialchars($_POST['tingkat'] ?? ''),
                'jumlah_siswa' => (int)($_POST['jumlah_siswa'] ?? 0),
                'tahun_ajaran' => htmlspecialchars($_POST['tahun_ajaran'] ?? '')
            ];
            
            if ($this->siswaModel->update($id, $data)) {
                $this->setFlash('success', 'Data siswa berhasil diperbarui');
            } else {
                $this->setFlash('error', 'Gagal memperbarui data siswa');
            }
        }
        
        $this->redirect('admin/siswa');
    }
    
    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->siswaModel->delete($id)) {
                $this->setFlash('success', 'Data siswa berhasil dihapus');
            } else {
                $this->setFlash('error', 'Gagal menghapus data siswa');
            }
        }
        
        $this->redirect('admin/siswa');
    }
}
