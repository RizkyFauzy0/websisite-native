<?php

class SliderModel {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    // Get all sliders
    public function getAll() {
        $this->db->query('SELECT * FROM sliders ORDER BY urutan ASC, created_at DESC');
        return $this->db->resultSet();
    }
    
    // Get slider by ID
    public function getById($id) {
        $this->db->query('SELECT * FROM sliders WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    
    // Get active sliders for frontend
    public function getActiveSliders() {
        $this->db->query('SELECT * FROM sliders WHERE status = :status ORDER BY urutan ASC');
        $this->db->bind(':status', 'aktif');
        return $this->db->resultSet();
    }
    
    // Create new slider
    public function create($data) {
        $this->db->query('INSERT INTO sliders (judul, deskripsi, gambar, urutan, status) 
                          VALUES (:judul, :deskripsi, :gambar, :urutan, :status)');
        
        $this->db->bind(':judul', $data['judul']);
        $this->db->bind(':deskripsi', $data['deskripsi']);
        $this->db->bind(':gambar', $data['gambar']);
        $this->db->bind(':urutan', $data['urutan']);
        $this->db->bind(':status', $data['status']);
        
        return $this->db->execute();
    }
    
    // Update slider
    public function update($id, $data) {
        $sql = 'UPDATE sliders SET judul = :judul, deskripsi = :deskripsi, urutan = :urutan, status = :status';
        
        if (isset($data['gambar'])) {
            $sql .= ', gambar = :gambar';
        }
        
        $sql .= ' WHERE id = :id';
        
        $this->db->query($sql);
        $this->db->bind(':id', $id);
        $this->db->bind(':judul', $data['judul']);
        $this->db->bind(':deskripsi', $data['deskripsi']);
        $this->db->bind(':urutan', $data['urutan']);
        $this->db->bind(':status', $data['status']);
        
        if (isset($data['gambar'])) {
            $this->db->bind(':gambar', $data['gambar']);
        }
        
        return $this->db->execute();
    }
    
    // Delete slider
    public function delete($id) {
        $this->db->query('DELETE FROM sliders WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
    
    // Get total count
    public function getTotalCount() {
        $this->db->query('SELECT COUNT(*) as total FROM sliders');
        $result = $this->db->single();
        return $result->total;
    }
}
