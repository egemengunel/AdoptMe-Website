<?php

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
        
        error_log("Login attempt - Email: " . $email);
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            error_log("User found in database");
            error_log("Stored hash: " . $user['password']);
            error_log("Provided password: " . $password);
            
            if (password_verify($password, $user['password'])) {
                error_log("Password verified successfully");
                // Remove password before storing in session
                unset($user['password']);
                $_SESSION['user'] = $user;
                error_log("Session data set: " . print_r($_SESSION, true));
                return true;
            } else {
                error_log("Password verification failed");
            }
        } else {
            error_log("No user found with email: " . $email);
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
        // Unset all session variables
        $_SESSION = array();
        
        // Destroy the session cookie
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time()-3600, '/');
        }
        
        // Destroy the session
        session_destroy();
    }
    
    public function isLoggedIn() {
        return isset($_SESSION['user']);
    }
} 