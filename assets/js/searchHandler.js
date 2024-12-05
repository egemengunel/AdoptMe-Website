document.addEventListener('DOMContentLoaded', function() {
    // Get all necessary elements
    const searchButton = document.getElementById('search-button');
    const searchInput = document.querySelector('.search-input');
    const animalSelect = document.getElementById('animal-select');
    const animalIcon = document.getElementById('animal-icon');

    // Icon update function
    function updateIcon(value) {
        if (value === 'cats') {
            animalIcon.src = animalIcon.getAttribute('data-cat-icon');
            animalIcon.alt = 'Cat Icon';
        } else {
            animalIcon.src = animalIcon.getAttribute('data-dog-icon');
            animalIcon.alt = 'Dog Icon';
        }
    }

    // Search function
    function performSearch() {
        console.log('Search initiated'); // Debug log
        const searchTerm = searchInput.value.trim();
        const animalType = animalSelect.value;
        
        // Convert animal type to match database format
        const dbAnimalType = animalType === 'dogs' ? 'dog' : 'cat';
        
        // Construct URL
        const searchParams = new URLSearchParams();
        if (searchTerm) searchParams.append('search', searchTerm);
        searchParams.append('type', animalType);
        
        // Redirect to browse page
        window.location.href = `browseAnimals.php?${searchParams.toString()}`;
    }

    // Event Listeners
    if (searchButton) {
        searchButton.addEventListener('click', performSearch);
    }

    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                performSearch();
            }
        });
    }

    if (animalSelect) {
        animalSelect.addEventListener('change', function(e) {
            updateIcon(e.target.value);
        });
    }

    // Initialize icon
    updateIcon(animalSelect.value);
});