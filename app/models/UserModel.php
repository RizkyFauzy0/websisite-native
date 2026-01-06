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
}
