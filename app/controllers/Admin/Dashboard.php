<?php

class Dashboard extends Controller {
    
    public function __construct() {
        $this->requireLogin();
        $this->dashboardModel = $this->model('DashboardModel');
    }
    
    public function index() {
        $data = [
            'title' => 'Dashboard',
            'active_menu' => 'dashboard',
            'stats' => $this->dashboardModel->getStatistics(),
            'recent_berita' => $this->dashboardModel->getRecentBerita(5),
            'recent_kontak' => $this->dashboardModel->getRecentKontak(5)
        ];
        
        $this->view('admin/dashboard', $data);
    }
}
