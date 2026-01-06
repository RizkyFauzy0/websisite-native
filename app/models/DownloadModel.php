<?php

class DownloadModel {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    // Get all downloads
    public function getAllDownloads() {
        $this->db->query('SELECT * FROM downloads ORDER BY tanggal_upload DESC');
        return $this->db->resultSet();
    }
    
    // Increment download count
    public function incrementDownload($id) {
        $this->db->query('UPDATE downloads SET jumlah_download = jumlah_download + 1 WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
    
    // Get file by id
    public function getFileById($id) {
        $this->db->query('SELECT * FROM downloads WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    
    // Admin methods
    
    // Get all downloads for admin
    public function getAll() {
        $this->db->query('SELECT * FROM downloads ORDER BY tanggal_upload DESC');
        return $this->db->resultSet();
    }
    
    // Get download by ID
    public function getById($id) {
        $this->db->query('SELECT * FROM downloads WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    
    // Create new download
    public function create($data) {
        $this->db->query('INSERT INTO downloads (judul, deskripsi, nama_file, ukuran_file, tanggal_upload) 
                          VALUES (:judul, :deskripsi, :nama_file, :ukuran_file, :tanggal_upload)');
        
        $this->db->bind(':judul', $data['judul']);
        $this->db->bind(':deskripsi', $data['deskripsi']);
        $this->db->bind(':nama_file', $data['nama_file']);
        $this->db->bind(':ukuran_file', $data['ukuran_file']);
        $this->db->bind(':tanggal_upload', $data['tanggal_upload']);
        
        return $this->db->execute();
    }
    
    // Update download
    public function update($id, $data) {
        $sql = 'UPDATE downloads SET judul = :judul, deskripsi = :deskripsi, tanggal_upload = :tanggal_upload';
        
        if (isset($data['nama_file'])) {
            $sql .= ', nama_file = :nama_file, ukuran_file = :ukuran_file';
        }
        
        $sql .= ' WHERE id = :id';
        
        $this->db->query($sql);
        $this->db->bind(':id', $id);
        $this->db->bind(':judul', $data['judul']);
        $this->db->bind(':deskripsi', $data['deskripsi']);
        $this->db->bind(':tanggal_upload', $data['tanggal_upload']);
        
        if (isset($data['nama_file'])) {
            $this->db->bind(':nama_file', $data['nama_file']);
            $this->db->bind(':ukuran_file', $data['ukuran_file']);
        }
        
        return $this->db->execute();
    }
    
    // Delete download
    public function delete($id) {
        $this->db->query('DELETE FROM downloads WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
