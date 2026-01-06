<?php

class KontakController extends Controller {
    
    public function __construct() {
        $this->requireLogin();
        $this->kontakModel = $this->model('KontakModel');
    }
    
    public function index() {
        $data = [
            'title' => 'Pesan Kontak',
            'active_menu' => 'kontak',
            'kontak_list' => $this->kontakModel->getAll()
        ];
        
        $this->view('admin/kontak/index', $data);
    }
    
    public function updateStatus($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $status = $_POST['status'] ?? 'dibaca';
            
            if ($this->kontakModel->updateStatus($id, $status)) {
                $this->setFlash('success', 'Status berhasil diperbarui');
            } else {
                $this->setFlash('error', 'Gagal memperbarui status');
            }
        }
        
        $this->redirect('admin/kontak');
    }
    
    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->kontakModel->delete($id)) {
                $this->setFlash('success', 'Pesan berhasil dihapus');
            } else {
                $this->setFlash('error', 'Gagal menghapus pesan');
            }
        }
        
        $this->redirect('admin/kontak');
    }
}
