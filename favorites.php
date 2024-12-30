<?php
// favorites.php

session_start();
require_once 'includes/db.php';
require_once 'includes/FavoriteManager.php';

if (!isset($_SESSION['user']['user_id'])) {
    header('Location: auth.php?mode=signin');
    exit;
}

$favoriteManager = new FavoriteManager($conn);
$favorites = $favoriteManager->getFavorites($_SESSION['user']['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Favorites - AdoptMe</title>
    <link rel="stylesheet" href="assets/css/global.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="assets/css/animalCard.css">
    <link rel="stylesheet" href="assets/css/textStyles.css">
    <link rel="stylesheet" href="assets/css/animalPages.css">
</head>
<body>
    <?php include 'templates/header.php'; ?>
    
    <div class="wrapper">
        <div class="content-wrapper">
            <div class="content-container">
                <div class="title-section">
                    <h1 class="page-title">Favorites</h1>
                    <hr class="title-divider" />
                </div>

                <div class="main-content">
                    <div class="animal-cards-row">
                        <?php if (empty($favorites)): ?>
                            <p>You haven't favorited any animals yet.</p>
                        <?php else: ?>
                            <?php foreach ($favorites as $animal): ?>
                                <?php
                                $animalId = $animal['animal_id'];
                                $imageSrc = $animal['image_url'];
                                $animalName = $animal['name'] . ', ' . $animal['breed'];
                                include 'templates/animalCard.php';
                                ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php include 'templates/footer.php'; ?>
    </div>
</body>
</html>