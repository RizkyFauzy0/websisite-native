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
}
