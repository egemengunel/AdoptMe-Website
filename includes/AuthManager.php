<?php
session_start();
require_once 'db_connect.php';

class AuthManager {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    public function login($email, $password) {
        $stmt = $this->conn->prepare("SELECT user_id, username, email, password, profile_picture_url FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            error_log("Attempting login for email: " . $email);
            error_log("Stored hash: " . $user['password']);
            if (password_verify($password, $user['password'])) {
                // Remove password before storing in session
                unset($user['password']);
                $_SESSION['user'] = $user;
                return true;
            }
        }
        return false;
    }
    
    public function register($username, $email, $password) {
        // Check if email already exists
        $stmt = $this->conn->prepare("SELECT user_id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            return false; // Email already exists
        }
        
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert new user
        $stmt = $this->conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashed_password);
        
        return $stmt->execute();
    }
    
    public function logout() {
        session_unset();
        session_destroy();
    }
    
    public function isLoggedIn() {
        return isset($_SESSION['user']);
    }
} 