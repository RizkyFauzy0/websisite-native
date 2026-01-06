<?php

class GuruModel {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    // Get all guru
    public function getAll() {
        $this->db->query('SELECT * FROM guru ORDER BY nama_guru ASC');
        return $this->db->resultSet();
    }
    
    // Get guru by ID
    public function getById($id) {
        $this->db->query('SELECT * FROM guru WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    
    // Get active guru for frontend
    public function getActiveGuru() {
        $this->db->query('SELECT * FROM guru WHERE status = :status ORDER BY nama_guru ASC');
        $this->db->bind(':status', 'aktif');
        return $this->db->resultSet();
    }
    
    // Create new guru
    public function create($data) {
        $this->db->query('INSERT INTO guru (nama_guru, nip, foto, mata_pelajaran, pendidikan, email, no_telp, status) 
                          VALUES (:nama_guru, :nip, :foto, :mata_pelajaran, :pendidikan, :email, :no_telp, :status)');
        
        $this->db->bind(':nama_guru', $data['nama_guru']);
        $this->db->bind(':nip', $data['nip']);
        $this->db->bind(':foto', $data['foto']);
        $this->db->bind(':mata_pelajaran', $data['mata_pelajaran']);
        $this->db->bind(':pendidikan', $data['pendidikan']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':no_telp', $data['no_telp']);
        $this->db->bind(':status', $data['status']);
        
        return $this->db->execute();
    }
    
    // Update guru
    public function update($id, $data) {
        $sql = 'UPDATE guru SET nama_guru = :nama_guru, nip = :nip, mata_pelajaran = :mata_pelajaran, 
                pendidikan = :pendidikan, email = :email, no_telp = :no_telp, status = :status';
        
        if (isset($data['foto'])) {
            $sql .= ', foto = :foto';
        }
        
        $sql .= ' WHERE id = :id';
        
        $this->db->query($sql);
        $this->db->bind(':id', $id);
        $this->db->bind(':nama_guru', $data['nama_guru']);
        $this->db->bind(':nip', $data['nip']);
        $this->db->bind(':mata_pelajaran', $data['mata_pelajaran']);
        $this->db->bind(':pendidikan', $data['pendidikan']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':no_telp', $data['no_telp']);
        $this->db->bind(':status', $data['status']);
        
        if (isset($data['foto'])) {
            $this->db->bind(':foto', $data['foto']);
        }
        
        return $this->db->execute();
    }
    
    // Delete guru
    public function delete($id) {
        $this->db->query('DELETE FROM guru WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
    
    // Get total count
    public function getTotalCount() {
        $this->db->query('SELECT COUNT(*) as total FROM guru WHERE status = :status');
        $this->db->bind(':status', 'aktif');
        $result = $this->db->single();
        return $result->total;
    }
}
