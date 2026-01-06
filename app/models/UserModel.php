<?php

class UserModel {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    // Check user login
    public function login($username, $password) {
        $this->db->query('SELECT * FROM users WHERE username = :username');
        $this->db->bind(':username', $username);
        $user = $this->db->single();
        
        if ($user && password_verify($password, $user->password)) {
            return $user;
        }
        
        return false;
    }
    
    // Get user by id
    public function getUserById($id) {
        $this->db->query('SELECT * FROM users WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    
    // Get all users
    public function getAll() {
        $this->db->query('SELECT id, username, nama_lengkap, email, created_at FROM users ORDER BY created_at DESC');
        return $this->db->resultSet();
    }
    
    // Get by ID for admin
    public function getById($id) {
        $this->db->query('SELECT id, username, nama_lengkap, email, created_at FROM users WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    
    // Create new user
    public function create($data) {
        $this->db->query('INSERT INTO users (username, password, nama_lengkap, email) 
                          VALUES (:username, :password, :nama_lengkap, :email)');
        
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':password', password_hash($data['password'], PASSWORD_DEFAULT));
        $this->db->bind(':nama_lengkap', $data['nama_lengkap']);
        $this->db->bind(':email', $data['email']);
        
        return $this->db->execute();
    }
    
    // Update user
    public function update($id, $data) {
        if (!empty($data['password'])) {
            $this->db->query('UPDATE users 
                              SET username = :username, password = :password, 
                                  nama_lengkap = :nama_lengkap, email = :email 
                              WHERE id = :id');
            $this->db->bind(':password', password_hash($data['password'], PASSWORD_DEFAULT));
        } else {
            $this->db->query('UPDATE users 
                              SET username = :username, nama_lengkap = :nama_lengkap, email = :email 
                              WHERE id = :id');
        }
        
        $this->db->bind(':id', $id);
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':nama_lengkap', $data['nama_lengkap']);
        $this->db->bind(':email', $data['email']);
        
        return $this->db->execute();
    }
    
    // Delete user
    public function delete($id) {
        $this->db->query('DELETE FROM users WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
    
    // Check if username exists
    public function usernameExists($username, $excludeId = null) {
        if ($excludeId) {
            $this->db->query('SELECT COUNT(*) as count FROM users WHERE username = :username AND id != :id');
            $this->db->bind(':id', $excludeId);
        } else {
            $this->db->query('SELECT COUNT(*) as count FROM users WHERE username = :username');
        }
        $this->db->bind(':username', $username);
        $result = $this->db->single();
        return $result->count > 0;
    }
}
