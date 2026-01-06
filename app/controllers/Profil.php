<?php

class Profil extends Controller {
    
    public function __construct() {
        $this->profilModel = $this->model('ProfilModel');
        $this->homeModel = $this->model('HomeModel');
    }
    
    private function loadView($jenis, $title) {
        $profil = $this->profilModel->getProfilByJenis($jenis);
        
        $data = [
            'title' => $title,
            'settings' => $this->homeModel->getSettings(),
            'profil' => $profil,
            'page_title' => $title
        ];
        
        $this->view('frontend/profil', $data);
    }
    
    public function visiMisi() {
        $this->loadView('visi_misi', 'Visi Misi');
    }
    
    public function sejarah() {
        $this->loadView('sejarah', 'Sejarah Singkat');
    }
    
    public function strukturOrganisasi() {
        $this->loadView('struktur_organisasi', 'Struktur Organisasi');
    }
    
    public function keunggulan() {
        $this->loadView('keunggulan', 'Keunggulan');
    }
}
