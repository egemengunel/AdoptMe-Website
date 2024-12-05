<?php
// Include header
include 'templates/header.php';

// Determine the animal type (dogs or cats)
$animal_type = isset($_GET['type']) ? $_GET['type'] : 'dogs';

// Set variables based on the animal type
if ($animal_type === 'cats') {
    $page_title = 'Browse All Cats';
    $animal_name = 'Cat';
    $plural_animal_name = 'Cats';
} else {
    $animal_type = 'dogs'; // Default to 'dogs' if invalid type is provided
    $page_title = 'Browse All Dogs';
    $animal_name = 'Dog';
    $plural_animal_name = 'Dogs';
}

// Ensure the type matches the database values
$animal_type = ($animal_type === 'dogs') ? 'dog' : 'cat';

// Include necessary CSS files
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $page_title; ?> - AdoptMe</title>
    <link rel="stylesheet" href="assets/css/global.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="assets/css/animalPages.css">
    <link rel="stylesheet" href="assets/css/animalCard.css">
    <link rel="stylesheet" href="assets/css/textStyles.css">
</head>
<body>
    <div class="wrapper">
        <div class="content-container">
            <!-- Title with line -->
            <div class="title-section">
                <h1 class="page-title"><?php echo $page_title; ?></h1>
                <hr class="title-divider" />
            </div>

            <!-- Main Content Wrapper -->
            <div class="main-content">
                <!-- Include the filtration tool -->
                <?php include 'templates/filterTool.php'; ?>

                <!-- Animal Cards Row -->
                <div class="animal-cards-row">
                    <?php
                    require_once 'includes/db_connect.php';
                    require_once 'includes/AnimalManager.php';
                    $animalManager = new AnimalManager($conn);

                    // Get animals based on the type (dogs/cats)
                    $animals = $animalManager->getAnimalsByType($animal_type);

                    if (empty($animals)) {
                        echo "<p>No {$plural_animal_name} available at the moment.</p>";
                    } else {
                        foreach ($animals as $animal) {
                            $animalId = $animal['animal_id'];
                            $imageSrc = $animal['image_url'];
                            $animalName = $animal['name'] . ', ' . $animal['breed'];
                            include 'templates/animalCard.php';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>

        <?php
        // Include footer
        include 'templates/footer.php';
        ?>
    </div>
</body>
</html>