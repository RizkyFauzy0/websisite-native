<?php

class HomeModel {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    // Get school settings
    public function getSettings() {
        $this->db->query('SELECT * FROM settings WHERE id = 1');
        return $this->db->single();
    }
    
    // Get active sliders
    public function getSliders() {
        $this->db->query('SELECT * FROM sliders WHERE status = :status ORDER BY urutan ASC');
        $this->db->bind(':status', 'aktif');
        return $this->db->resultSet();
    }
    
    // Get sambutan kepala sekolah
    public function getSambutan() {
        $this->db->query('SELECT * FROM sambutan ORDER BY id DESC LIMIT 1');
        return $this->db->single();
    }
    
    // Get latest news
    public function getLatestBerita($limit = 6) {
        $this->db->query('SELECT * FROM berita WHERE status = :status ORDER BY tanggal_publish DESC LIMIT :limit');
        $this->db->bind(':status', 'publish');
        $this->db->bind(':limit', $limit, PDO::PARAM_INT);
        return $this->db->resultSet();
    }
    
    // Get active announcements
    public function getActiveAnnouncements($limit = 5) {
        $this->db->query('SELECT * FROM pengumuman WHERE status = :status AND (tanggal_selesai IS NULL OR tanggal_selesai >= CURDATE()) ORDER BY tanggal_mulai DESC LIMIT :limit');
        $this->db->bind(':status', 'aktif');
        $this->db->bind(':limit', $limit, PDO::PARAM_INT);
        return $this->db->resultSet();
    }
    
    // Get student statistics
    public function getSiswaStats() {
        $this->db->query('SELECT * FROM siswa_stats ORDER BY tingkat ASC');
        return $this->db->resultSet();
    }
    
    // Get active teachers
    public function getGuru($limit = 8) {
        $this->db->query('SELECT * FROM guru WHERE status = :status ORDER BY nama_guru ASC LIMIT :limit');
        $this->db->bind(':status', 'aktif');
        $this->db->bind(':limit', $limit, PDO::PARAM_INT);
        return $this->db->resultSet();
    }
}
