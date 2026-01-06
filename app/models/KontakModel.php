<?php

class KontakModel {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    // Add contact message
    public function addKontak($data) {
        $this->db->query('INSERT INTO kontak (nama, email, subjek, pesan) VALUES (:nama, :email, :subjek, :pesan)');
        $this->db->bind(':nama', $data['nama']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':subjek', $data['subjek']);
        $this->db->bind(':pesan', $data['pesan']);
        
        return $this->db->execute();
    }
    
    // Admin methods
    
    // Get all kontak
    public function getAll() {
        $this->db->query('SELECT * FROM kontak ORDER BY created_at DESC');
        return $this->db->resultSet();
    }
    
    // Get kontak by ID
    public function getById($id) {
        $this->db->query('SELECT * FROM kontak WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    
    // Update status kontak
    public function updateStatus($id, $status) {
        $this->db->query('UPDATE kontak SET status = :status WHERE id = :id');
        $this->db->bind(':id', $id);
        $this->db->bind(':status', $status);
        return $this->db->execute();
    }
    
    // Delete kontak
    public function delete($id) {
        $this->db->query('DELETE FROM kontak WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
    
    // Get unread count
    public function getUnreadCount() {
        $this->db->query('SELECT COUNT(*) as total FROM kontak WHERE status = :status');
        $this->db->bind(':status', 'baru');
        $result = $this->db->single();
        return $result->total;
    }
}
