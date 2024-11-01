<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AdoptMe</title>
    <link rel="stylesheet" type="text/css" href="assets/css/main.css">
    <link rel="stylesheet" type="text/css" href="assets/css/header.css">
    <link rel="stylesheet" type="text/css" href="assets/css/footer.css">
    <link rel="stylesheet" type="text/css" href="assets/css/animalCard.css">
</head>
<body>
    <?php include 'templates/header.php'; ?>

    <div class="main-content">
        <div class="hero-title">
            <span class="hero-text">Every Pet Deserves a Loving Home.</span><br>
            <span class="highlighted-text">Adopt</span>
            <span class="hero-text"> a Pet Today</span>
        </div>
        <div class="hero-subtitle">
            <span class="sub-text">Browse our available animals and learn more about the adoption process. Together, we can </span>
            <span class="highlighted-sub-text">rescue, rehabilitate, and rehome pets in need.</span>
            <span class="sub-text"> Thank you for supporting our mission to bring joy to families through pet adoption.</span>
        </div>
        
        <div class="search-bar">
        <div class="custom-dropdown">
            <img class="dropdown-icon" src="assets/icons/DogSit.png" alt="Dog Icon">
            <select class="search-category search-element">
                <option value="dogs">Dogs</option>
                <option value="cats">Cats</option>
            </select>
            <img class="arrow-icon" src="assets/icons/Expand_Arrow.png" alt="Arrow Icon">
        </div>
        <input type="text" class="search-input search-element" placeholder="Search by breed, age or name...">
        <button class="search-button search-element">Search</button>
        </div>


        <div class="animals-container">
            <div class="animal-category" style="width: 100%; text-align: left; font-size: 24px; font-weight: bold; margin-bottom: 20px;">Dogs <span class="animal-count">137</span></div>
            <div class="animal-cards-row" style="display: flex; gap: 20px;">
                <?php
                    $imageSrc = "https://via.placeholder.com/290x213";
                    $animalName = "Freddy, Husky";
                    include 'templates/animalCard.php';
                ?>
                <?php
                    $imageSrc = "https://via.placeholder.com/290x213";
                    $animalName = "Ella, Labrador Retriever";
                    include 'templates/animalCard.php';
                ?>
                <?php
                    $imageSrc = "https://via.placeholder.com/290x213";
                    $animalName = "German Shepherd";
                    include 'templates/animalCard.php';
                ?>
                <?php
                    $imageSrc = "https://via.placeholder.com/290x213";
                    $animalName = "Brad, Bull Dog";
                    include 'templates/animalCard.php';
                ?>
            </div>

            <div class="animal-category" style="width: 100%; text-align: left; font-size: 24px; font-weight: bold; margin-top: 63px;">Cats <span class="animal-count">137</span></div>
            <div class="animal-cards-row" style="display: flex; gap: 20px;">
                <?php
                    $imageSrc = "https://via.placeholder.com/290x213";
                    $animalName = "Freddy, Husky";
                    include 'templates/animalCard.php';
                ?>
                <?php
                    $imageSrc = "https://via.placeholder.com/290x213";
                    $animalName = "Ella, Labrador Retriever";
                    include 'templates/animalCard.php';
                ?>
                <?php
                    $imageSrc = "https://via.placeholder.com/290x213";
                    $animalName = "German Shepherd";
                    include 'templates/animalCard.php';
                ?>
                <?php
                    $imageSrc = "https://via.placeholder.com/290x213";
                    $animalName = "Brad, Bull Dog";
                    include 'templates/animalCard.php';
                ?>
            </div>
        </div>
    </div>

    <?php include 'templates/footer.php'; ?>
</body>
</html>
