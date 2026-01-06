<?php

class LinkAplikasi extends Controller {
    
    public function __construct() {
        $this->linkModel = $this->model('LinkAplikasiModel');
        $this->homeModel = $this->model('HomeModel');
    }
    
    public function index() {
        $data = [
            'title' => 'Link Aplikasi',
            'settings' => $this->homeModel->getSettings(),
            'links' => $this->linkModel->getActiveLinks()
        ];
        
        $this->view('frontend/link_aplikasi', $data);
    }
}
