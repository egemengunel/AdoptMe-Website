<?php
// Database configuration
$db_host = 'localhost';
$db_user = 'root';      // Default XAMPP username
$db_pass = '';          // Empty password by default in XAMPP
$db_name = 'adoptme_db';

// Create connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset to utf8
$conn->set_charset("utf8");
