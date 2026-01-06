<?php

class GaleriFotoModel {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    // Get all galeri foto
    public function getAll() {
        $this->db->query('SELECT * FROM galeri_foto ORDER BY tanggal_upload DESC');
        return $this->db->resultSet();
    }
    
    // Get galeri foto by ID
    public function getById($id) {
        $this->db->query('SELECT * FROM galeri_foto WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    
    // Get galeri foto with pagination
    public function getWithPagination($limit = 12, $offset = 0) {
        $this->db->query('SELECT * FROM galeri_foto ORDER BY tanggal_upload DESC LIMIT :limit OFFSET :offset');
        $this->db->bind(':limit', $limit, PDO::PARAM_INT);
        $this->db->bind(':offset', $offset, PDO::PARAM_INT);
        return $this->db->resultSet();
    }
    
    // Create new galeri foto
    public function create($data) {
        $this->db->query('INSERT INTO galeri_foto (judul, deskripsi, gambar, tanggal_upload) 
                          VALUES (:judul, :deskripsi, :gambar, :tanggal_upload)');
        
        $this->db->bind(':judul', $data['judul']);
        $this->db->bind(':deskripsi', $data['deskripsi']);
        $this->db->bind(':gambar', $data['gambar']);
        $this->db->bind(':tanggal_upload', $data['tanggal_upload']);
        
        return $this->db->execute();
    }
    
    // Update galeri foto
    public function update($id, $data) {
        $sql = 'UPDATE galeri_foto SET judul = :judul, deskripsi = :deskripsi, tanggal_upload = :tanggal_upload';
        
        if (isset($data['gambar'])) {
            $sql .= ', gambar = :gambar';
        }
        
        $sql .= ' WHERE id = :id';
        
        $this->db->query($sql);
        $this->db->bind(':id', $id);
        $this->db->bind(':judul', $data['judul']);
        $this->db->bind(':deskripsi', $data['deskripsi']);
        $this->db->bind(':tanggal_upload', $data['tanggal_upload']);
        
        if (isset($data['gambar'])) {
            $this->db->bind(':gambar', $data['gambar']);
        }
        
        return $this->db->execute();
    }
    
    // Delete galeri foto
    public function delete($id) {
        $this->db->query('DELETE FROM galeri_foto WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
    
    // Get total count
    public function getTotalCount() {
        $this->db->query('SELECT COUNT(*) as total FROM galeri_foto');
        $result = $this->db->single();
        return $result->total;
    }
}
