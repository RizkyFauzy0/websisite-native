<?php

class SambutanModel {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    // Get all sambutan (typically just one active)
    public function getAll() {
        $this->db->query('SELECT * FROM sambutan ORDER BY created_at DESC');
        return $this->db->resultSet();
    }
    
    // Get sambutan by ID
    public function getById($id) {
        $this->db->query('SELECT * FROM sambutan WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    
    // Get active sambutan for frontend
    public function getActiveSambutan() {
        $this->db->query('SELECT * FROM sambutan ORDER BY created_at DESC LIMIT 1');
        return $this->db->single();
    }
    
    // Create new sambutan
    public function create($data) {
        $this->db->query('INSERT INTO sambutan (nama_kepsek, jabatan, foto, isi_sambutan) 
                          VALUES (:nama_kepsek, :jabatan, :foto, :isi_sambutan)');
        
        $this->db->bind(':nama_kepsek', $data['nama_kepsek']);
        $this->db->bind(':jabatan', $data['jabatan']);
        $this->db->bind(':foto', $data['foto']);
        $this->db->bind(':isi_sambutan', $data['isi_sambutan']);
        
        return $this->db->execute();
    }
    
    // Update sambutan
    public function update($id, $data) {
        $sql = 'UPDATE sambutan SET nama_kepsek = :nama_kepsek, jabatan = :jabatan, isi_sambutan = :isi_sambutan';
        
        if (isset($data['foto'])) {
            $sql .= ', foto = :foto';
        }
        
        $sql .= ' WHERE id = :id';
        
        $this->db->query($sql);
        $this->db->bind(':id', $id);
        $this->db->bind(':nama_kepsek', $data['nama_kepsek']);
        $this->db->bind(':jabatan', $data['jabatan']);
        $this->db->bind(':isi_sambutan', $data['isi_sambutan']);
        
        if (isset($data['foto'])) {
            $this->db->bind(':foto', $data['foto']);
        }
        
        return $this->db->execute();
    }
    
    // Delete sambutan
    public function delete($id) {
        $this->db->query('DELETE FROM sambutan WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
