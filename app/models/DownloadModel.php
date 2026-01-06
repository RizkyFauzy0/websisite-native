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
}
