<?php

class Prestasi extends Controller {
    
    public function __construct() {
        $this->prestasiModel = $this->model('PrestasiModel');
        $this->homeModel = $this->model('HomeModel');
    }
    
    private function loadView($jenis, $title, $page = 1) {
        $limit = 12;
        $offset = ($page - 1) * $limit;
        
        $prestasi = $this->prestasiModel->getPrestasiByJenis($jenis, $limit, $offset);
        $totalPrestasi = $this->prestasiModel->getTotalByJenis($jenis);
        $totalPages = ceil($totalPrestasi / $limit);
        
        $data = [
            'title' => $title,
            'settings' => $this->homeModel->getSettings(),
            'prestasi' => $prestasi,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'page_title' => $title,
            'jenis' => $jenis
        ];
        
        $this->view('frontend/prestasi', $data);
    }
    
    public function siswa($page = 1) {
        $this->loadView('siswa', 'Prestasi Siswa', $page);
    }
    
    public function guru($page = 1) {
        $this->loadView('guru', 'Prestasi Guru', $page);
    }
    
    public function sekolah($page = 1) {
        $this->loadView('sekolah', 'Prestasi Sekolah', $page);
    }
}
