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
    
    // Admin methods
    
    // Get all berita for admin (including drafts)
    public function getAll() {
        $this->db->query('SELECT * FROM berita ORDER BY created_at DESC');
        return $this->db->resultSet();
    }
    
    // Get berita by ID for admin
    public function getById($id) {
        $this->db->query('SELECT * FROM berita WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    
    // Create new berita
    public function create($data) {
        $this->db->query('INSERT INTO berita (judul, slug, isi_berita, gambar, penulis, tanggal_publish, status) 
                          VALUES (:judul, :slug, :isi_berita, :gambar, :penulis, :tanggal_publish, :status)');
        
        $this->db->bind(':judul', $data['judul']);
        $this->db->bind(':slug', $data['slug']);
        $this->db->bind(':isi_berita', $data['isi_berita']);
        $this->db->bind(':gambar', $data['gambar']);
        $this->db->bind(':penulis', $data['penulis']);
        $this->db->bind(':tanggal_publish', $data['tanggal_publish']);
        $this->db->bind(':status', $data['status']);
        
        return $this->db->execute();
    }
    
    // Update berita
    public function update($id, $data) {
        $sql = 'UPDATE berita SET judul = :judul, slug = :slug, isi_berita = :isi_berita, 
                penulis = :penulis, tanggal_publish = :tanggal_publish, status = :status';
        
        if (isset($data['gambar'])) {
            $sql .= ', gambar = :gambar';
        }
        
        $sql .= ' WHERE id = :id';
        
        $this->db->query($sql);
        $this->db->bind(':id', $id);
        $this->db->bind(':judul', $data['judul']);
        $this->db->bind(':slug', $data['slug']);
        $this->db->bind(':isi_berita', $data['isi_berita']);
        $this->db->bind(':penulis', $data['penulis']);
        $this->db->bind(':tanggal_publish', $data['tanggal_publish']);
        $this->db->bind(':status', $data['status']);
        
        if (isset($data['gambar'])) {
            $this->db->bind(':gambar', $data['gambar']);
        }
        
        return $this->db->execute();
    }
    
    // Delete berita
    public function delete($id) {
        $this->db->query('DELETE FROM berita WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
