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
        const searchTerm = searchInput.value.trim();
        const animalType = animalSelect.value;
        
        // Build search URL with parameters
        let searchUrl = `browseAnimals.php?type=${animalType}`;
        
        if (searchTerm) {
            searchUrl += `&search=${encodeURIComponent(searchTerm)}`;
        }
        
        // Redirect to browse page with search parameters
        window.location.href = searchUrl;
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