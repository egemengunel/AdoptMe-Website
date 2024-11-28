<?php
require_once 'includes/db_connect.php';
require_once 'includes/AuthManager.php';
$auth = new AuthManager($conn);
$auth->logout();
header('Location: index.php');
exit;
?> 