<?php

class GaleriModel {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    // Get all photo gallery
    public function getAllFoto($limit = 12, $offset = 0) {
        $this->db->query('SELECT * FROM galeri_foto ORDER BY tanggal_upload DESC LIMIT :limit OFFSET :offset');
        $this->db->bind(':limit', $limit, PDO::PARAM_INT);
        $this->db->bind(':offset', $offset, PDO::PARAM_INT);
        return $this->db->resultSet();
    }
    
    // Get total foto count
    public function getTotalFoto() {
        $this->db->query('SELECT COUNT(*) as total FROM galeri_foto');
        $result = $this->db->single();
        return $result->total;
    }
    
    // Get all video gallery
    public function getAllVideo($limit = 12, $offset = 0) {
        $this->db->query('SELECT * FROM galeri_video ORDER BY tanggal_upload DESC LIMIT :limit OFFSET :offset');
        $this->db->bind(':limit', $limit, PDO::PARAM_INT);
        $this->db->bind(':offset', $offset, PDO::PARAM_INT);
        return $this->db->resultSet();
    }
    
    // Get total video count
    public function getTotalVideo() {
        $this->db->query('SELECT COUNT(*) as total FROM galeri_video');
        $result = $this->db->single();
        return $result->total;
    }
}
