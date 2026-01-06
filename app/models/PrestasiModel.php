<?php

class PrestasiModel {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    // Get prestasi by jenis
    public function getPrestasiByJenis($jenis, $limit = 12, $offset = 0) {
        $this->db->query('SELECT * FROM prestasi WHERE jenis = :jenis ORDER BY tahun DESC, id DESC LIMIT :limit OFFSET :offset');
        $this->db->bind(':jenis', $jenis);
        $this->db->bind(':limit', $limit, PDO::PARAM_INT);
        $this->db->bind(':offset', $offset, PDO::PARAM_INT);
        return $this->db->resultSet();
    }
    
    // Get total prestasi count by jenis
    public function getTotalByJenis($jenis) {
        $this->db->query('SELECT COUNT(*) as total FROM prestasi WHERE jenis = :jenis');
        $this->db->bind(':jenis', $jenis);
        $result = $this->db->single();
        return $result->total;
    }
    
    // Admin methods
    
    // Get all prestasi
    public function getAll() {
        $this->db->query('SELECT * FROM prestasi ORDER BY tahun DESC, created_at DESC');
        return $this->db->resultSet();
    }
    
    // Get prestasi by ID
    public function getById($id) {
        $this->db->query('SELECT * FROM prestasi WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    
    // Create new prestasi
    public function create($data) {
        $this->db->query('INSERT INTO prestasi (jenis, judul, deskripsi, tingkat, tahun, gambar) 
                          VALUES (:jenis, :judul, :deskripsi, :tingkat, :tahun, :gambar)');
        
        $this->db->bind(':jenis', $data['jenis']);
        $this->db->bind(':judul', $data['judul']);
        $this->db->bind(':deskripsi', $data['deskripsi']);
        $this->db->bind(':tingkat', $data['tingkat']);
        $this->db->bind(':tahun', $data['tahun']);
        $this->db->bind(':gambar', $data['gambar']);
        
        return $this->db->execute();
    }
    
    // Update prestasi
    public function update($id, $data) {
        $sql = 'UPDATE prestasi SET jenis = :jenis, judul = :judul, deskripsi = :deskripsi, 
                tingkat = :tingkat, tahun = :tahun';
        
        if (isset($data['gambar'])) {
            $sql .= ', gambar = :gambar';
        }
        
        $sql .= ' WHERE id = :id';
        
        $this->db->query($sql);
        $this->db->bind(':id', $id);
        $this->db->bind(':jenis', $data['jenis']);
        $this->db->bind(':judul', $data['judul']);
        $this->db->bind(':deskripsi', $data['deskripsi']);
        $this->db->bind(':tingkat', $data['tingkat']);
        $this->db->bind(':tahun', $data['tahun']);
        
        if (isset($data['gambar'])) {
            $this->db->bind(':gambar', $data['gambar']);
        }
        
        return $this->db->execute();
    }
    
    // Delete prestasi
    public function delete($id) {
        $this->db->query('DELETE FROM prestasi WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
