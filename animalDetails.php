<?php
// Add these at the very top of the file
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'includes/db.php';
require_once 'includes/AnimalManager.php';

// Let's also add some debug output
$animalId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
echo "Animal ID: " . $animalId . "<br>";

// Initialize AnimalManager
$animalManager = new AnimalManager($conn);

// Get animal details
$animal = $animalManager->getAnimalById($animalId);
echo "Animal data: <pre>";
print_r($animal);
echo "</pre>";

// Get all images for this animal
$stmt = $conn->prepare("
    SELECT image_url 
    FROM animal_images 
    WHERE animal_id = ?
    ORDER BY is_primary DESC
");
$stmt->bind_param("i", $animalId);
$stmt->execute();
$images = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
echo "Images data: <pre>";
print_r($images);
echo "</pre>";

// If animal not found, redirect to home
if (!$animal) {
    header('Location: index.php');
    exit();
}
?>
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
                            <?php foreach ($images as $image): ?>
                                <div class="gallery-item" style="background-image: url('<?php echo htmlspecialchars($image['image_url']); ?>');"></div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Animal Details -->
                    <div class="details-section">
                        <div class="details-header">
                            <h1><?php echo htmlspecialchars($animal['name']); ?></h1>
                            <button class="favorite-btn">Add to Favorites ♡</button>
                        </div>

                        <div class="about-section">
                            <h2>About</h2>
                            <hr class="divider-primary">
                            <p class="description">
                                <?php echo htmlspecialchars($animal['description']); ?>
                            </p>
                        </div>

                        <hr class="divider-secondary">
                        
                        <div class="characteristics">
                            <p class="characteristics-text">
                                <?php echo htmlspecialchars($animal['age']); ?> · 
                                <?php echo htmlspecialchars($animal['gender']); ?> · 
                                <?php echo htmlspecialchars($animal['size']); ?> · 
                                <?php echo htmlspecialchars($animal['color']); ?>
                            </p>
                            <p class="breed-location">
                                <?php echo htmlspecialchars($animal['breed']); ?> · 
                                <?php echo htmlspecialchars($animal['location']); ?>
                            </p>
                        </div>

                        <hr class="divider-secondary">

                        <div class="contact-section">
                            <h2>Address · Contact</h2>
                            <p class="address"><?php echo htmlspecialchars($animal['location']); ?></p>
                            <p class="phone">Call Adoption Center +1 256436621</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include 'templates/footer.php'; ?>
    </div>
</body>
</html>