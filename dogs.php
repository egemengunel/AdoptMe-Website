<?php
// Include header
include 'templates/header.php';
?>
<link rel="stylesheet" href="assets/css/header.css">
<link rel="stylesheet" type="text/css" href="assets/css/textStyles.css">
<link rel="stylesheet" href="assets/css/animalPages.css">
<link rel="stylesheet" href="assets/css/animalCard.css"> 

<div class="wrapper">
    <div class="content-container">
        <!-- Title with line -->
        <div class="title-section">
            <h1 class="page-title">Browse All Dogs</h1>
            <hr class="title-divider" />
        </div>

        <!-- Main Content Wrapper -->
        <div class="main-content">
            <!-- Include the filtration tool -->
            <?php include 'templates/filterTool.php'; ?>

            <!-- Animal Cards Row -->
            <div class="animal-cards-row">
                <?php
                    $imageSrc = "https://via.placeholder.com/290x213";
                    $animalName = "Freddy, Husky";
                    include 'templates/animalCard.php';

                    $imageSrc = "https://via.placeholder.com/290x213";
                    $animalName = "Ella, Labrador Retriever";
                    include 'templates/animalCard.php';

                    $imageSrc = "https://via.placeholder.com/290x213";
                    $animalName = "German Shepherd";
                    include 'templates/animalCard.php';

                    // Add more animal cards as needed
                ?>
            </div>
        </div>
    </div>

    <?php
    // Include footer
    include 'templates/footer.php';
    ?>
</div>