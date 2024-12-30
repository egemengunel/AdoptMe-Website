<?php
session_start();
require_once 'db.php';
require_once 'FavoriteManager.php';

// Check if user is logged in
if (!isset($_SESSION['user']['user_id'])) {
    // Store the animal page URL they were trying to favorite
    $_SESSION['redirect_after_login'] = '../animalDetails.php?id=' . $_POST['animal_id'];
    header('Location: ../auth.php?mode=signin');
    exit;
}

if (isset($_POST['animal_id'])) {
    $animalId = (int)$_POST['animal_id'];
    $userId = $_SESSION['user']['user_id'];
    
    $favoriteManager = new FavoriteManager($conn);
    $favoriteManager->toggleFavorite($userId, $animalId);
    
    // Redirect back to the animal details page
    header('Location: ../animalDetails.php?id=' . $animalId);
    exit;
} 