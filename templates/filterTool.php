<?php
require_once 'includes/FilterManager.php';

$filterManager = new FilterManager($conn);
$filterOptions = $filterManager->getFilterOptions($animal_type ?? 'dog');
$currentFilters = $filterManager->getCurrentFilters();

// Determine if this is for upload or browse
$isUpload = isset($isUploadPage) && $isUploadPage;
$layoutClass = $isUpload ? 'filter-tool--horizontal' : 'filter-tool--vertical';
?>

<form class="filter-tool <?php echo $layoutClass; ?>" method="<?php echo $isUpload ? 'POST' : 'GET'; ?>" action="">
    <?php if (!$isUpload): ?>
        <input type="hidden" name="type" value="<?php echo htmlspecialchars($currentFilters['type']); ?>">
    <?php endif; ?>
    
    <div class="filter-options">
        <?php if ($isUpload): ?>
        <!-- Type selector only shows on upload page -->
        <div class="filter-item">
            <select name="type" class="filter-select" id="animalType">
                <option value="">Select Type</option>
                <option value="dog">Dog</option>
                <option value="cat">Cat</option>
            </select>
        </div>
        <?php endif; ?>

        <div class="filter-item">
            <select name="age" class="filter-select">
                <option value="">Any Age</option>
                <?php foreach ($filterOptions['ages'] as $age): ?>
                    <option value="<?php echo htmlspecialchars($age); ?>" 
                            <?php echo $currentFilters['age'] === $age ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($age); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="filter-item">
            <select name="breed" class="filter-select" id="breedSelect" <?php echo $isUpload ? 'disabled' : ''; ?>>
                <option value="">Any Breed</option>
                <?php foreach ($filterOptions['breeds'] as $breed): ?>
                    <option value="<?php echo htmlspecialchars($breed); ?>"
                            <?php echo $currentFilters['breed'] === $breed ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($breed); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="filter-item">
            <select name="gender" class="filter-select">
                <option value="">Any Gender</option>
                <?php foreach ($filterOptions['genders'] as $gender): ?>
                    <option value="<?php echo htmlspecialchars($gender); ?>"
                            <?php echo $currentFilters['gender'] === $gender ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($gender); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="filter-item">
            <select name="color" class="filter-select">
                <option value="">Any Color</option>
                <?php foreach ($filterOptions['colors'] as $color): ?>
                    <option value="<?php echo htmlspecialchars($color); ?>"
                            <?php echo $currentFilters['color'] === $color ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($color); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="filter-item">
            <select name="size" class="filter-select">
                <option value="">Any Size</option>
                <?php foreach ($filterOptions['sizes'] as $size): ?>
                    <option value="<?php echo htmlspecialchars($size); ?>"
                            <?php echo $currentFilters['size'] === $size ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($size); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="filter-item">
            <select name="location" class="filter-select">
                <option value="">Any Location</option>
                <?php foreach ($filterOptions['locations'] as $location): ?>
                    <option value="<?php echo htmlspecialchars($location); ?>"
                            <?php echo $currentFilters['location'] === $location ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($location); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <?php if (!$isUpload): ?>
        <button type="submit" class="filter-apply-btn">Apply Filters</button>
    <?php endif; ?>
</form>