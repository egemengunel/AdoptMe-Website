<?php
include 'templates/header.php';

// Check if user is logged in
if (!$auth->isLoggedIn()) {
    header('Location: auth.php');
    exit();
}

// Get user data from session
$userId = $_SESSION['user']['user_id'];
$stmt = $conn->prepare("SELECT username, bio, profile_picture_url FROM users WHERE user_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$name = $user['username'] ?? $_SESSION['user']['username'];
$bio = $user['bio'] ?? '';
$profilePicture = $user['profile_picture_url'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Profile - AdoptMe</title>
    <link rel="stylesheet" href="assets/css/global.css">
    <link rel="stylesheet" href="assets/css/textStyles.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="assets/css/profile.css">
</head>
<body>
    <div class="wrapper">
        <div class="content-wrapper">
            <div class="content-container">
                <div class="profile-container">
                    <h1 class="page-title">Your Profile</h1>
                    <div class="profile-divider"></div>

                    <div class="profile-content">
                        <div class="profile-picture-container">
                            <img src="<?php echo $profilePicture ?: 'assets/images/default_pfp.jpg'; ?>" alt="Profile Picture" class="profile-picture">
                            <label class="profile-picture-label">
                                <img src="assets/icons/camera.svg" alt="Edit" class="edit-icon">
                                Change Profile Picture
                                <input type="file" accept="image/*" style="display: none;" id="profile-picture-input">
                            </label>
                        </div>

                        <div class="profile-info">
                            <div class="profile-name-container">
                                <input type="text" class="profile-name-input" value="<?php echo htmlspecialchars($name); ?>" placeholder="Your Name">
                                <img src="assets/icons/edit.svg" alt="Edit" class="edit-icon">
                            </div>
                            <textarea class="profile-bio" placeholder="Tell us a little bit about yourself.."><?php echo htmlspecialchars($bio); ?></textarea>
                            <button class="save-profile-btn" id="saveProfile">Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include 'templates/footer.php'; ?>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const profilePictureInput = document.getElementById('profile-picture-input');
            const profilePicture = document.querySelector('.profile-picture');
            const nameInput = document.querySelector('.profile-name-input');
            const bioInput = document.querySelector('.profile-bio');
            const saveButton = document.getElementById('saveProfile');
            
            let hasChanges = false;

            // Handle profile picture change
            profilePictureInput.addEventListener('change', async function(e) {
                const file = e.target.files[0];
                if (!file) return;

                const formData = new FormData();
                formData.append('profile_picture', file);

                try {
                    const response = await fetch('update_profile.php', {
                        method: 'POST',
                        body: formData
                    });
                    
                    if (response.ok) {
                        const result = await response.json();
                        if (result.success) {
                            profilePicture.src = result.image_url;
                            hasChanges = true;
                        }
                    }
                } catch (error) {
                    console.error('Error uploading profile picture:', error);
                }
            });

            // Track changes in inputs
            [nameInput, bioInput].forEach(input => {
                input.addEventListener('input', () => {
                    hasChanges = true;
                    saveButton.style.opacity = '1';
                });
            });

            // Handle save button click
            saveButton.addEventListener('click', async function() {
                if (!hasChanges) return;

                try {
                    const response = await fetch('update_profile.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            username: nameInput.value,
                            bio: bioInput.value
                        })
                    });
                    
                    if (response.ok) {
                        const result = await response.json();
                        if (result.success) {
                            hasChanges = false;
                            saveButton.style.opacity = '0.5';
                            showNotification('Profile updated successfully!');
                        }
                    }
                } catch (error) {
                    console.error('Error updating profile:', error);
                    showNotification('Error updating profile', 'error');
                }
            });

            function showNotification(message, type = 'success') {
                const notification = document.createElement('div');
                notification.className = `notification ${type}`;
                notification.textContent = message;
                document.body.appendChild(notification);
                
                setTimeout(() => {
                    notification.remove();
                }, 3000);
            }
        });
    </script>
</body>
</html>
