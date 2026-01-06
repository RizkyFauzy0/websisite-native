<?php

class Berita extends Controller {
    
    public function __construct() {
        $this->beritaModel = $this->model('BeritaModel');
        $this->homeModel = $this->model('HomeModel');
    }
    
    public function index($page = 1) {
        $limit = 9;
        $offset = ($page - 1) * $limit;
        
        $berita = $this->beritaModel->getAllBerita($limit, $offset);
        $totalBerita = $this->beritaModel->getTotalBerita();
        $totalPages = ceil($totalBerita / $limit);
        
        $data = [
            'title' => 'Berita Sekolah',
            'settings' => $this->homeModel->getSettings(),
            'berita' => $berita,
            'currentPage' => $page,
            'totalPages' => $totalPages
        ];
        
        $this->view('frontend/berita_list', $data);
    }
    
    public function detail($slug) {
        $berita = $this->beritaModel->getBeritaBySlug($slug);
        
        if (!$berita) {
            $this->redirect('berita');
            return;
        }
        
        // Increment read count
        $this->beritaModel->incrementDibaca($berita->id);
        $berita->dibaca++;
        
        // Get related news
        $relatedBerita = $this->beritaModel->getRelatedBerita($berita->id, 3);
        
        $data = [
            'title' => $berita->judul,
            'settings' => $this->homeModel->getSettings(),
            'berita' => $berita,
            'relatedBerita' => $relatedBerita
        ];
        
        $this->view('frontend/berita_detail', $data);
    }
}
