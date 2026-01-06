<?php

class Kontak extends Controller {
    
    public function __construct() {
        $this->kontakModel = $this->model('KontakModel');
        $this->homeModel = $this->model('HomeModel');
    }
    
    public function index() {
        $data = [
            'title' => 'Kontak',
            'settings' => $this->homeModel->getSettings()
        ];
        
        $this->view('frontend/kontak', $data);
    }
    
    public function submit() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'nama' => $_POST['nama'] ?? '',
                'email' => $_POST['email'] ?? '',
                'subjek' => $_POST['subjek'] ?? '',
                'pesan' => $_POST['pesan'] ?? ''
            ];
            
            // Validation
            if (empty($data['nama']) || empty($data['email']) || empty($data['pesan'])) {
                $this->setFlash('error', 'Semua field wajib diisi');
                $this->redirect('kontak');
                return;
            }
            
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $this->setFlash('error', 'Email tidak valid');
                $this->redirect('kontak');
                return;
            }
            
            if ($this->kontakModel->addKontak($data)) {
                $this->setFlash('success', 'Pesan Anda berhasil dikirim. Terima kasih!');
            } else {
                $this->setFlash('error', 'Gagal mengirim pesan. Silakan coba lagi.');
            }
            
            $this->redirect('kontak');
        } else {
            $this->redirect('kontak');
        }
    }
}
