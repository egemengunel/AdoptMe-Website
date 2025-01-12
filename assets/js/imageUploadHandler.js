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
}); 