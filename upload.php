<?php
include 'templates/header.php';
require_once 'includes/UploadManager.php';

$isUploadPage = true;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Upload Animal - AdoptMe</title>
    <link rel="stylesheet" href="assets/css/global.css">
    <link rel="stylesheet" href="assets/css/textStyles.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="assets/css/filterTool.css">
    <link rel="stylesheet" href="assets/css/upload.css">
</head>
<body>
    <div class="wrapper">
        <div class="content-container">
            <div class="title-section">
                <h1 class="page-title">Upload Your Shelter Animal ❤️</h1>
                <hr class="title-divider" />
            </div>

            <form class="upload-form" method="POST" action="upload.php" enctype="multipart/form-data">
                <!-- Image Upload Section -->
                <div class="image-upload-section">
                    <div class="image-preview-grid">
                        <div class="image-preview-box"></div>
                        <div class="image-preview-box"></div>
                        <div class="image-preview-box"></div>
                        <div class="image-preview-box"></div>
                    </div>
                    <p class="upload-instruction">add photos of your animal</p>
                </div>

                <!-- Animal Details Section -->
                <div class="animal-details">
                    <input type="text" 
                           name="name" 
                           placeholder="Name of Your Animal" 
                           class="animal-name-input">
                    
                    <textarea name="description" 
                             placeholder="tell us a little about your animal..." 
                             class="animal-description"></textarea>

                    <?php include 'templates/filterTool.php'; ?>

                    <div class="form-actions">
                        <button type="button" class="cancel-btn">Cancel</button>
                        <button type="submit" class="save-btn">Save</button>
                    </div>
                </div>
            </form>
        </div>

        <?php include 'templates/footer.php'; ?>
    </div>

    <script src="assets/js/imageUploadHandler.js"></script>
</body>
</html>
