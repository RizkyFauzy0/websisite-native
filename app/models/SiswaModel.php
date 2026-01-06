<?php

class SiswaModel {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    // Get all siswa stats
    public function getAll() {
        $this->db->query('SELECT * FROM siswa_stats ORDER BY tingkat ASC');
        return $this->db->resultSet();
    }
    
    // Get siswa by ID
    public function getById($id) {
        $this->db->query('SELECT * FROM siswa_stats WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    
    // Get total siswa
    public function getTotalSiswa() {
        $this->db->query('SELECT SUM(jumlah_siswa) as total FROM siswa_stats');
        $result = $this->db->single();
        return $result->total ?? 0;
    }
    
    // Create new siswa stat
    public function create($data) {
        $this->db->query('INSERT INTO siswa_stats (tingkat, jumlah_siswa, tahun_ajaran) 
                          VALUES (:tingkat, :jumlah_siswa, :tahun_ajaran)');
        
        $this->db->bind(':tingkat', $data['tingkat']);
        $this->db->bind(':jumlah_siswa', $data['jumlah_siswa']);
        $this->db->bind(':tahun_ajaran', $data['tahun_ajaran']);
        
        return $this->db->execute();
    }
    
    // Update siswa stat
    public function update($id, $data) {
        $this->db->query('UPDATE siswa_stats 
                          SET tingkat = :tingkat, jumlah_siswa = :jumlah_siswa, tahun_ajaran = :tahun_ajaran 
                          WHERE id = :id');
        
        $this->db->bind(':id', $id);
        $this->db->bind(':tingkat', $data['tingkat']);
        $this->db->bind(':jumlah_siswa', $data['jumlah_siswa']);
        $this->db->bind(':tahun_ajaran', $data['tahun_ajaran']);
        
        return $this->db->execute();
    }
    
    // Delete siswa stat
    public function delete($id) {
        $this->db->query('DELETE FROM siswa_stats WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
