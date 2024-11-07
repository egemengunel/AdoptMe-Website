document.addEventListener('DOMContentLoaded', function() {
    const animalSelect = document.getElementById('animal-select');
    const animalIcon = document.getElementById('animal-icon');

    // Function to update icon based on selection
    function updateIcon(value) {
        if (value === 'cats') {
            animalIcon.src = animalIcon.getAttribute('data-cat-icon');
            animalIcon.alt = 'Cat Icon';
        } else {
            animalIcon.src = animalIcon.getAttribute('data-dog-icon');
            animalIcon.alt = 'Dog Icon';
        }
    }

    // Add change event listener to select element
    animalSelect.addEventListener('change', function(e) {
        updateIcon(e.target.value);
    });

    // Initialize icon based on default selection
    updateIcon(animalSelect.value);
});