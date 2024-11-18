<div class="animal-card">
    <a href="animalDetails.php?id=<?php echo $animalId; ?>" class="animal-link">
        <div class="image-container">
            <img class="animal-img" src="<?php echo $imageSrc; ?>" alt="<?php echo $animalName; ?>" />
        </div>
        <div class="animal-item"><?php echo $animalName; ?></div>
    </a>
</div>