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
                    // Fetch animal data from the database based on $animal_type
                    // For now, we'll use placeholder data

                    // Placeholder data array
                    $animals = [
                        [
                            'imageSrc' => 'https://via.placeholder.com/290x213',
                            'animalName' => 'Freddy, Husky',
                        ],
                        [
                            'imageSrc' => 'https://via.placeholder.com/290x213',
                            'animalName' => 'Ella, Labrador Retriever',
                        ],
                        [
                            'imageSrc' => 'https://via.placeholder.com/290x213',
                            'animalName' => 'Max, German Shepherd',
                        ],
                        // Add more animals as needed
                    ];

                    // Loop through the animals and include the animal card template
                    foreach ($animals as $animal) {
                        $imageSrc = $animal['imageSrc'];
                        $animalName = $animal['animalName'];
                        include 'templates/animalCard.php';
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