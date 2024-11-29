<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include AuthManager if needed
require_once 'includes/db_connect.php';
require_once 'includes/AuthManager.php';

// Initialize AuthManager
$auth = new AuthManager($conn);

// Call the logout method
$auth->logout();

// Redirect to home page
header('Location: index.php');
exit();
?> 