<?php

class DashboardModel {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    // Get statistics
    public function getStatistics() {
        $stats = [];
        
        // Total berita
        $this->db->query('SELECT COUNT(*) as total FROM berita');
        $result = $this->db->single();
        $stats['berita'] = $result->total;
        
        // Total guru
        $this->db->query('SELECT COUNT(*) as total FROM guru');
        $result = $this->db->single();
        $stats['guru'] = $result->total;
        
        // Total siswa
        $this->db->query('SELECT SUM(jumlah_siswa) as total FROM siswa_stats');
        $result = $this->db->single();
        $stats['siswa'] = $result->total ?? 0;
        
        // Total prestasi
        $this->db->query('SELECT COUNT(*) as total FROM prestasi');
        $result = $this->db->single();
        $stats['prestasi'] = $result->total;
        
        // Total galeri foto
        $this->db->query('SELECT COUNT(*) as total FROM galeri_foto');
        $result = $this->db->single();
        $stats['galeri_foto'] = $result->total;
        
        // Total galeri video
        $this->db->query('SELECT COUNT(*) as total FROM galeri_video');
        $result = $this->db->single();
        $stats['galeri_video'] = $result->total;
        
        // Unread kontak
        $this->db->query('SELECT COUNT(*) as total FROM kontak WHERE status = :status');
        $this->db->bind(':status', 'baru');
        $result = $this->db->single();
        $stats['kontak_baru'] = $result->total;
        
        // Active pengumuman
        $this->db->query('SELECT COUNT(*) as total FROM pengumuman WHERE status = :status');
        $this->db->bind(':status', 'aktif');
        $result = $this->db->single();
        $stats['pengumuman'] = $result->total;
        
        return $stats;
    }
    
    // Get recent berita
    public function getRecentBerita($limit = 5) {
        $this->db->query('SELECT * FROM berita ORDER BY created_at DESC LIMIT :limit');
        $this->db->bind(':limit', $limit, PDO::PARAM_INT);
        return $this->db->resultSet();
    }
    
    // Get recent kontak
    public function getRecentKontak($limit = 5) {
        $this->db->query('SELECT * FROM kontak ORDER BY created_at DESC LIMIT :limit');
        $this->db->bind(':limit', $limit, PDO::PARAM_INT);
        return $this->db->resultSet();
    }
}
