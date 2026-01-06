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
}
