<?php

class LinkAplikasiModel {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    // Get all active links
    public function getActiveLinks() {
        $this->db->query('SELECT * FROM link_aplikasi WHERE status = :status ORDER BY urutan ASC');
        $this->db->bind(':status', 'aktif');
        return $this->db->resultSet();
    }
    
    // Admin methods
    
    // Get all link aplikasi
    public function getAll() {
        $this->db->query('SELECT * FROM link_aplikasi ORDER BY urutan ASC, created_at DESC');
        return $this->db->resultSet();
    }
    
    // Get link aplikasi by ID
    public function getById($id) {
        $this->db->query('SELECT * FROM link_aplikasi WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    
    // Create new link aplikasi
    public function create($data) {
        $this->db->query('INSERT INTO link_aplikasi (nama_aplikasi, deskripsi, url, icon, urutan, status) 
                          VALUES (:nama_aplikasi, :deskripsi, :url, :icon, :urutan, :status)');
        
        $this->db->bind(':nama_aplikasi', $data['nama_aplikasi']);
        $this->db->bind(':deskripsi', $data['deskripsi']);
        $this->db->bind(':url', $data['url']);
        $this->db->bind(':icon', $data['icon']);
        $this->db->bind(':urutan', $data['urutan']);
        $this->db->bind(':status', $data['status']);
        
        return $this->db->execute();
    }
    
    // Update link aplikasi
    public function update($id, $data) {
        $sql = 'UPDATE link_aplikasi SET nama_aplikasi = :nama_aplikasi, deskripsi = :deskripsi, 
                url = :url, urutan = :urutan, status = :status';
        
        if (isset($data['icon'])) {
            $sql .= ', icon = :icon';
        }
        
        $sql .= ' WHERE id = :id';
        
        $this->db->query($sql);
        $this->db->bind(':id', $id);
        $this->db->bind(':nama_aplikasi', $data['nama_aplikasi']);
        $this->db->bind(':deskripsi', $data['deskripsi']);
        $this->db->bind(':url', $data['url']);
        $this->db->bind(':urutan', $data['urutan']);
        $this->db->bind(':status', $data['status']);
        
        if (isset($data['icon'])) {
            $this->db->bind(':icon', $data['icon']);
        }
        
        return $this->db->execute();
    }
    
    // Delete link aplikasi
    public function delete($id) {
        $this->db->query('DELETE FROM link_aplikasi WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
