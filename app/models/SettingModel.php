<?php

class SettingModel {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    // Get settings (typically just one row)
    public function getSettings() {
        $this->db->query('SELECT * FROM settings LIMIT 1');
        return $this->db->single();
    }
    
    // Update settings
    public function update($data) {
        // Check if settings exist
        $existing = $this->getSettings();
        
        if ($existing) {
            // Update existing settings
            $sql = 'UPDATE settings SET nama_sekolah = :nama_sekolah, alamat = :alamat, 
                    no_telp = :no_telp, email = :email, website = :website, 
                    koordinat_maps = :koordinat_maps, facebook = :facebook, 
                    instagram = :instagram, youtube = :youtube';
            
            if (isset($data['logo'])) {
                $sql .= ', logo = :logo';
            }
            
            $sql .= ' WHERE id = :id';
            
            $this->db->query($sql);
            $this->db->bind(':id', $existing->id);
        } else {
            // Insert new settings
            $sql = 'INSERT INTO settings (nama_sekolah, logo, alamat, no_telp, email, website, 
                    koordinat_maps, facebook, instagram, youtube) 
                    VALUES (:nama_sekolah, :logo, :alamat, :no_telp, :email, :website, 
                    :koordinat_maps, :facebook, :instagram, :youtube)';
            
            $this->db->query($sql);
            
            if (isset($data['logo'])) {
                $this->db->bind(':logo', $data['logo']);
            } else {
                $this->db->bind(':logo', null);
            }
        }
        
        $this->db->bind(':nama_sekolah', $data['nama_sekolah']);
        $this->db->bind(':alamat', $data['alamat']);
        $this->db->bind(':no_telp', $data['no_telp']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':website', $data['website']);
        $this->db->bind(':koordinat_maps', $data['koordinat_maps']);
        $this->db->bind(':facebook', $data['facebook']);
        $this->db->bind(':instagram', $data['instagram']);
        $this->db->bind(':youtube', $data['youtube']);
        
        if ($existing && isset($data['logo'])) {
            $this->db->bind(':logo', $data['logo']);
        }
        
        return $this->db->execute();
    }
}
