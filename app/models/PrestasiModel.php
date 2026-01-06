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
}
