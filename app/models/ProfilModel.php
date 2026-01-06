<?php

class ProfilModel {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    // Get profil by jenis
    public function getProfilByJenis($jenis) {
        $this->db->query('SELECT * FROM profil WHERE jenis = :jenis');
        $this->db->bind(':jenis', $jenis);
        return $this->db->single();
    }
    
    // Get all profil
    public function getAllProfil() {
        $this->db->query('SELECT * FROM profil');
        return $this->db->resultSet();
    }
    
    // Admin methods
    
    // Get all for admin
    public function getAll() {
        $this->db->query('SELECT * FROM profil ORDER BY jenis ASC');
        return $this->db->resultSet();
    }
    
    // Get profil by ID
    public function getById($id) {
        $this->db->query('SELECT * FROM profil WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    
    // Create or update profil (upsert based on jenis)
    public function createOrUpdate($data) {
        // Check if profil exists for this jenis
        $existing = $this->getProfilByJenis($data['jenis']);
        
        if ($existing) {
            // Update existing
            $sql = 'UPDATE profil SET judul = :judul, isi_konten = :isi_konten';
            
            if (isset($data['gambar'])) {
                $sql .= ', gambar = :gambar';
            }
            
            $sql .= ' WHERE jenis = :jenis';
            
            $this->db->query($sql);
            $this->db->bind(':jenis', $data['jenis']);
            $this->db->bind(':judul', $data['judul']);
            $this->db->bind(':isi_konten', $data['isi_konten']);
            
            if (isset($data['gambar'])) {
                $this->db->bind(':gambar', $data['gambar']);
            }
        } else {
            // Create new
            $this->db->query('INSERT INTO profil (jenis, judul, isi_konten, gambar) 
                              VALUES (:jenis, :judul, :isi_konten, :gambar)');
            
            $this->db->bind(':jenis', $data['jenis']);
            $this->db->bind(':judul', $data['judul']);
            $this->db->bind(':isi_konten', $data['isi_konten']);
            $this->db->bind(':gambar', $data['gambar'] ?? null);
        }
        
        return $this->db->execute();
    }
    
    // Delete profil
    public function delete($id) {
        $this->db->query('DELETE FROM profil WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
