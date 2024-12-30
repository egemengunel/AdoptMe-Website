<?php
require_once 'includes/FilterManager.php';

$filterManager = new FilterManager($conn);
$filterOptions = $filterManager->getFilterOptions($animal_type);
$currentFilters = $filterManager->getCurrentFilters();

// Extract filter options
$ages = $filterOptions['ages'];
$breeds = $filterOptions['breeds'];
$colors = $filterOptions['colors'];
$sizes = $filterOptions['sizes'];
$genders = $filterOptions['genders'];
$locations = $filterOptions['locations'];

// Extract current values
$currentType = $currentFilters['type'];
$currentAge = $currentFilters['age'];
$currentBreed = $currentFilters['breed'];
$currentGender = $currentFilters['gender'];
$currentColor = $currentFilters['color'];
$currentSize = $currentFilters['size'];
$currentLocation = $currentFilters['location'];
?>

<form class="filter-tool" method="GET" action="">
    <input type="hidden" name="type" value="<?php echo htmlspecialchars($currentType); ?>">
    
    <div class="filter-options">
        <div class="filter-item">
            <select name="age" class="filter-select">
                <option value="">Any Age</option>
                <?php foreach ($ages as $age): ?>
                    <option value="<?php echo htmlspecialchars($age); ?>" 
                            <?php echo $currentAge === $age ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($age); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="filter-item">
            <select name="breed" class="filter-select">
                <option value="">Any Breed</option>
                <?php foreach ($breeds as $breed): ?>
                    <option value="<?php echo htmlspecialchars($breed); ?>"
                            <?php echo $currentBreed === $breed ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($breed); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="filter-item">
            <select name="gender" class="filter-select">
                <option value="">Any Gender</option>
                <?php foreach ($genders as $gender): ?>
                    <option value="<?php echo htmlspecialchars($gender); ?>"
                            <?php echo $currentGender === $gender ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($gender); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="filter-item">
            <select name="color" class="filter-select">
                <option value="">Any Color</option>
                <?php foreach ($colors as $color): ?>
                    <option value="<?php echo htmlspecialchars($color); ?>"
                            <?php echo $currentColor === $color ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($color); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="filter-item">
            <select name="size" class="filter-select">
                <option value="">Any Size</option>
                <?php foreach ($sizes as $size): ?>
                    <option value="<?php echo htmlspecialchars($size); ?>"
                            <?php echo $currentSize === $size ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($size); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="filter-item">
            <select name="location" class="filter-select">
                <option value="">Any Location</option>
                <?php foreach ($locations as $location): ?>
                    <option value="<?php echo htmlspecialchars($location); ?>"
                            <?php echo $currentLocation === $location ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($location); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="filter-apply-btn">Apply Filters</button>
    </div>
</form>

<script>
document.querySelectorAll('.filter-select').forEach(select => {
    select.addEventListener('change', () => {
        document.querySelector('.filter-tool').submit();
    });
});
</script>