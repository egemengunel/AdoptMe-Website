<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $animalName; ?> - AdoptMe</title>
    <link rel="stylesheet" href="assets/css/global.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="assets/css/animalDetails.css">
    <link rel="stylesheet" href="assets/css/textStyles.css">
</head>
<body>
    <div class="wrapper">
        <?php include 'templates/header.php'; ?>
        
        <div class="content-wrapper">
            <div class="content-container">
                <!-- Back Button with SVG -->
                <div class="back-link">
                    <a href="javascript:history.back()">
                        <img src="assets/icons/􀯶 Back to Search.svg" alt="Back to Search" class="back-icon">
                    </a>
                </div>

                <!-- Main Content Grid -->
                <div class="details-grid">
                    <!-- Image Gallery -->
                    <div class="image-gallery">
                        <div class="gallery-grid">
                            <div class="gallery-item"></div>
                            <div class="gallery-item"></div>
                            <div class="gallery-item"></div>
                            <div class="gallery-item"></div>
                        </div>
                    </div>

                    <!-- Animal Details - Removed the border here -->
                    <div class="details-section">
                        <div class="details-header">
                            <h1>Animal Name</h1>
                            <button class="favorite-btn">Add to Favorites ♡</button>
                        </div>

                        <div class="about-section">
                            <h2>About</h2>
                            <hr class="divider-primary">
                            <p class="description">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua...
                            </p>
                        </div>

                        <hr class="divider-secondary">
                        
                        <div class="characteristics">
                            <p class="characteristics-text">Adult · Female · Large · White / Cream</p>
                            <p class="breed-location">Bull Terrier · New York, NY</p>
                        </div>

                        <hr class="divider-secondary">

                        <div class="contact-section">
                            <h2>Address · Contact</h2>
                            <p class="address">Bla bla Street. St Martinas Adoption Centre 5464 New York</p>
                            <p class="phone">Call Adoption Center+1 256436621</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include 'templates/footer.php'; ?>
    </div>
</body>
</html>