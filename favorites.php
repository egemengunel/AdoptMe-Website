<?php
// favorites.php

include 'templates/header.php';
?>
<link rel="stylesheet" href="assets/css/global.css">
<link rel="stylesheet" href="assets/css/main.css">
<link rel="stylesheet" href="assets/css/header.css">
<link rel="stylesheet" href="assets/css/footer.css">
<link rel="stylesheet" href="assets/css/animalCard.css">
<link rel="stylesheet" href="assets/css/textStyles.css">
<link rel="stylesheet" href="assets/css/animalPages.css">

<div class="wrapper">
    <div class="content-wrapper">
        <div class="content-container">
            <!-- Page Title and Divider -->
            <div class="title-section">
                <h1 class="page-title">Favorites</h1>
                <hr class="title-divider" />
            </div>

            <!-- Main Content -->
            <div class="main-content">
                <!-- Animal Cards Row -->
                <div class="animal-cards-row">
                    <?php
                    $animalCards = [
                        ['imageSrc' => 'https://via.placeholder.com/290x213', 'animalName' => 'Freddy, Husky'],
                        ['imageSrc' => 'https://via.placeholder.com/290x213', 'animalName' => 'Ella, Labrador Retriever'],
                        ['imageSrc' => 'https://via.placeholder.com/290x213', 'animalName' => 'Brad, Bull Dog'],
                        ['imageSrc' => 'https://via.placeholder.com/290x213', 'animalName' => 'German Shepherd'],
                    ];

                    foreach ($animalCards as $animal) {
                        $imageSrc = $animal['imageSrc'];
                        $animalName = $animal['animalName'];
                        include 'templates/animalCard.php';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <?php include 'templates/footer.php'; ?>
</div>