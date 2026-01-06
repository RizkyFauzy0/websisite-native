<?php

class BeritaModel {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    // Get all published news with pagination
    public function getAllBerita($limit = 9, $offset = 0) {
        $this->db->query('SELECT * FROM berita WHERE status = :status ORDER BY tanggal_publish DESC LIMIT :limit OFFSET :offset');
        $this->db->bind(':status', 'publish');
        $this->db->bind(':limit', $limit, PDO::PARAM_INT);
        $this->db->bind(':offset', $offset, PDO::PARAM_INT);
        return $this->db->resultSet();
    }
    
    // Get total berita count
    public function getTotalBerita() {
        $this->db->query('SELECT COUNT(*) as total FROM berita WHERE status = :status');
        $this->db->bind(':status', 'publish');
        $result = $this->db->single();
        return $result->total;
    }
    
    // Get berita by slug
    public function getBeritaBySlug($slug) {
        $this->db->query('SELECT * FROM berita WHERE slug = :slug AND status = :status');
        $this->db->bind(':slug', $slug);
        $this->db->bind(':status', 'publish');
        return $this->db->single();
    }
    
    // Increment read count
    public function incrementDibaca($id) {
        $this->db->query('UPDATE berita SET dibaca = dibaca + 1 WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
    
    // Get related berita
    public function getRelatedBerita($currentId, $limit = 3) {
        $this->db->query('SELECT * FROM berita WHERE status = :status AND id != :id ORDER BY tanggal_publish DESC LIMIT :limit');
        $this->db->bind(':status', 'publish');
        $this->db->bind(':id', $currentId);
        $this->db->bind(':limit', $limit, PDO::PARAM_INT);
        return $this->db->resultSet();
    }
}
