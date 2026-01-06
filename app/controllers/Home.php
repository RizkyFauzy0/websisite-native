<?php

class Home extends Controller {
    
    public function __construct() {
        $this->homeModel = $this->model('HomeModel');
    }
    
    public function index() {
        $data = [
            'title' => 'Beranda',
            'settings' => $this->homeModel->getSettings(),
            'sliders' => $this->homeModel->getSliders(),
            'sambutan' => $this->homeModel->getSambutan(),
            'berita' => $this->homeModel->getLatestBerita(6),
            'pengumuman' => $this->homeModel->getActiveAnnouncements(5),
            'siswa_stats' => $this->homeModel->getSiswaStats(),
            'guru' => $this->homeModel->getGuru(8)
        ];
        
        $this->view('frontend/home', $data);
    }
}
