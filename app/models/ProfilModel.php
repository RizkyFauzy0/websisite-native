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
}
