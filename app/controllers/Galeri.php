<?php

class Galeri extends Controller {
    
    public function __construct() {
        $this->galeriModel = $this->model('GaleriModel');
        $this->homeModel = $this->model('HomeModel');
    }
    
    public function foto($page = 1) {
        $limit = 12;
        $offset = ($page - 1) * $limit;
        
        $foto = $this->galeriModel->getAllFoto($limit, $offset);
        $totalFoto = $this->galeriModel->getTotalFoto();
        $totalPages = ceil($totalFoto / $limit);
        
        $data = [
            'title' => 'Galeri Foto',
            'settings' => $this->homeModel->getSettings(),
            'foto' => $foto,
            'currentPage' => $page,
            'totalPages' => $totalPages
        ];
        
        $this->view('frontend/galeri_foto', $data);
    }
    
    public function video($page = 1) {
        $limit = 12;
        $offset = ($page - 1) * $limit;
        
        $video = $this->galeriModel->getAllVideo($limit, $offset);
        $totalVideo = $this->galeriModel->getTotalVideo();
        $totalPages = ceil($totalVideo / $limit);
        
        $data = [
            'title' => 'Galeri Video',
            'settings' => $this->homeModel->getSettings(),
            'video' => $video,
            'currentPage' => $page,
            'totalPages' => $totalPages
        ];
        
        $this->view('frontend/galeri_video', $data);
    }
}
