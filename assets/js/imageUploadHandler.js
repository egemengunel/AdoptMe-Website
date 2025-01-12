document.addEventListener('DOMContentLoaded', function() {
    const previewBoxes = document.querySelectorAll('.image-preview-box');
    let fileInput = document.createElement('input');
    fileInput.type = 'file';
    fileInput.multiple = true;
    fileInput.accept = 'image/*';
    fileInput.style.display = 'none';
    document.body.appendChild(fileInput);

    // Handle click on preview boxes
    previewBoxes.forEach(box => {
        box.addEventListener('click', () => {
            fileInput.click();
        });
    });

    // Handle file selection
    fileInput.addEventListener('change', function(e) {
        const files = Array.from(e.target.files);
        
        files.forEach((file, index) => {
            if (index < previewBoxes.length) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    previewBoxes[index].style.backgroundImage = `url(${e.target.result})`;
                    previewBoxes[index].style.backgroundSize = 'cover';
                    previewBoxes[index].style.backgroundPosition = 'center';
                };
                
                reader.readAsDataURL(file);
            }
        });
    });

    // Handle animal type selection
    const typeSelect = document.getElementById('animalType');
    const breedSelect = document.getElementById('breedSelect');

    if (typeSelect) {
        typeSelect.addEventListener('change', async function() {
            const selectedType = this.value;
            breedSelect.disabled = true;
            
            if (!selectedType) {
                breedSelect.innerHTML = '<option value="">Select Type First</option>';
                return;
            }

            try {
                const response = await fetch(`get_breeds.php?type=${selectedType}`);
                if (!response.ok) throw new Error('Network response was not ok');
                
                const breeds = await response.json();
                
                breedSelect.innerHTML = '<option value="">Select Breed</option>';
                breeds.forEach(breed => {
                    const option = document.createElement('option');
                    option.value = breed;
                    option.textContent = breed;
                    breedSelect.appendChild(option);
                });
                
                breedSelect.disabled = false;
            } catch (error) {
                console.error('Error fetching breeds:', error);
                breedSelect.innerHTML = '<option value="">Error loading breeds</option>';
            }
        });
    }
}); 