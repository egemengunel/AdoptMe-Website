<?php
// Include header
include 'templates/header.php';

// Determine the animal type (dogs or cats)
$animal_type = isset($_GET['type']) ? $_GET['type'] : 'dogs';
$search_term = isset($_GET['search']) ? $_GET['search'] : '';

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
$db_type = ($animal_type === 'dogs') ? 'dog' : 'cat';

require_once 'includes/db_connect.php';
require_once 'includes/AnimalManager.php';
require_once 'includes/FilterManager.php';

$animalManager = new AnimalManager($conn);
$filterManager = new FilterManager($conn);

// If there's a search term, use AnimalManager to search
if (!empty($search_term)) {
    $animals = $animalManager->getAnimalsByType($db_type, null, $search_term);
} else {
    // Get current filters
    $currentFilters = $filterManager->getCurrentFilters();
    
    // If any filters are active, use the filter system
    if ($filterManager->hasActiveFilters($currentFilters)) {
        $animals = $filterManager->getFilteredAnimals($currentFilters);
    } else {
        // If no filters, show all animals of the selected type
        $animals = $animalManager->getAnimalsByType($db_type);
    }
}
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
    <link rel="stylesheet" href="assets/css/filterTool.css">
</head>
<body>
    <div class="wrapper">
        <div class="content-container">
            <!-- Title with line -->
            <div class="title-section">
                <h1 class="page-title"><?php echo $page_title; ?></h1>
                <hr class="title-divider" />
            </div>

            <!-- Main Content -->
            <div class="main-content">
                <!-- Include the filtration tool -->
                <?php include 'templates/filterTool.php'; ?>

                <!-- Animal Cards Row -->
                <div class="animal-cards-row">
                    <?php
                    if (empty($animals)) {
                        echo "<p>No {$plural_animal_name} available matching your criteria.</p>";
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

        <?php include 'templates/footer.php'; ?>
    </div>
</body>
</html>