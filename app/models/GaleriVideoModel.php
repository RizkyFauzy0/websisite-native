<?php

class GaleriVideoModel {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    // Get all galeri video
    public function getAll() {
        $this->db->query('SELECT * FROM galeri_video ORDER BY tanggal_upload DESC');
        return $this->db->resultSet();
    }
    
    // Get galeri video by ID
    public function getById($id) {
        $this->db->query('SELECT * FROM galeri_video WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    
    // Get galeri video with pagination
    public function getWithPagination($limit = 12, $offset = 0) {
        $this->db->query('SELECT * FROM galeri_video ORDER BY tanggal_upload DESC LIMIT :limit OFFSET :offset');
        $this->db->bind(':limit', $limit, PDO::PARAM_INT);
        $this->db->bind(':offset', $offset, PDO::PARAM_INT);
        return $this->db->resultSet();
    }
    
    // Create new galeri video
    public function create($data) {
        $this->db->query('INSERT INTO galeri_video (judul, deskripsi, url_video, thumbnail, tanggal_upload) 
                          VALUES (:judul, :deskripsi, :url_video, :thumbnail, :tanggal_upload)');
        
        $this->db->bind(':judul', $data['judul']);
        $this->db->bind(':deskripsi', $data['deskripsi']);
        $this->db->bind(':url_video', $data['url_video']);
        $this->db->bind(':thumbnail', $data['thumbnail']);
        $this->db->bind(':tanggal_upload', $data['tanggal_upload']);
        
        return $this->db->execute();
    }
    
    // Update galeri video
    public function update($id, $data) {
        $sql = 'UPDATE galeri_video SET judul = :judul, deskripsi = :deskripsi, 
                url_video = :url_video, tanggal_upload = :tanggal_upload';
        
        if (isset($data['thumbnail'])) {
            $sql .= ', thumbnail = :thumbnail';
        }
        
        $sql .= ' WHERE id = :id';
        
        $this->db->query($sql);
        $this->db->bind(':id', $id);
        $this->db->bind(':judul', $data['judul']);
        $this->db->bind(':deskripsi', $data['deskripsi']);
        $this->db->bind(':url_video', $data['url_video']);
        $this->db->bind(':tanggal_upload', $data['tanggal_upload']);
        
        if (isset($data['thumbnail'])) {
            $this->db->bind(':thumbnail', $data['thumbnail']);
        }
        
        return $this->db->execute();
    }
    
    // Delete galeri video
    public function delete($id) {
        $this->db->query('DELETE FROM galeri_video WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
    
    // Get total count
    public function getTotalCount() {
        $this->db->query('SELECT COUNT(*) as total FROM galeri_video');
        $result = $this->db->single();
        return $result->total;
    }
}
