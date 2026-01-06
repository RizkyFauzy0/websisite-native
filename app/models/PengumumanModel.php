<?php

class PengumumanModel {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    // Get all pengumuman
    public function getAll() {
        $this->db->query('SELECT * FROM pengumuman ORDER BY tanggal_mulai DESC');
        return $this->db->resultSet();
    }
    
    // Get pengumuman by ID
    public function getById($id) {
        $this->db->query('SELECT * FROM pengumuman WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    
    // Get active pengumuman for frontend
    public function getActivePengumuman() {
        $this->db->query('SELECT * FROM pengumuman 
                          WHERE status = :status 
                          AND tanggal_mulai <= CURDATE() 
                          AND (tanggal_selesai IS NULL OR tanggal_selesai >= CURDATE())
                          ORDER BY tanggal_mulai DESC');
        $this->db->bind(':status', 'aktif');
        return $this->db->resultSet();
    }
    
    // Create new pengumuman
    public function create($data) {
        $this->db->query('INSERT INTO pengumuman (judul, isi_pengumuman, tanggal_mulai, tanggal_selesai, status) 
                          VALUES (:judul, :isi_pengumuman, :tanggal_mulai, :tanggal_selesai, :status)');
        
        $this->db->bind(':judul', $data['judul']);
        $this->db->bind(':isi_pengumuman', $data['isi_pengumuman']);
        $this->db->bind(':tanggal_mulai', $data['tanggal_mulai']);
        $this->db->bind(':tanggal_selesai', $data['tanggal_selesai']);
        $this->db->bind(':status', $data['status']);
        
        return $this->db->execute();
    }
    
    // Update pengumuman
    public function update($id, $data) {
        $this->db->query('UPDATE pengumuman 
                          SET judul = :judul, isi_pengumuman = :isi_pengumuman, 
                              tanggal_mulai = :tanggal_mulai, tanggal_selesai = :tanggal_selesai, 
                              status = :status 
                          WHERE id = :id');
        
        $this->db->bind(':id', $id);
        $this->db->bind(':judul', $data['judul']);
        $this->db->bind(':isi_pengumuman', $data['isi_pengumuman']);
        $this->db->bind(':tanggal_mulai', $data['tanggal_mulai']);
        $this->db->bind(':tanggal_selesai', $data['tanggal_selesai']);
        $this->db->bind(':status', $data['status']);
        
        return $this->db->execute();
    }
    
    // Delete pengumuman
    public function delete($id) {
        $this->db->query('DELETE FROM pengumuman WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
