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
                    <h1 class="profile-header">Your Profile</h1>
                    <div class="profile-divider"></div>

                    <div class="profile-content">
                        <div class="profile-picture-container">
                            <img src="<?php echo $profilePicture ?: 'assets/images/default-profile.png'; ?>" alt="Profile Picture" class="profile-picture">
                            <label class="profile-picture-label">
                                add a new profile picture
                                <input type="file" accept="image/*" style="display: none;" id="profile-picture-input">
                            </label>
                        </div>

                        <div class="profile-info">
                            <div class="profile-name"><?php echo htmlspecialchars($name); ?></div>
                            <textarea class="profile-bio" placeholder="tell us a little bit about yourself.."><?php echo htmlspecialchars($bio); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include 'templates/footer.php'; ?>
    </div>

    <script>
        // Handle profile picture upload
        document.getElementById('profile-picture-input').addEventListener('change', async function(e) {
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
                        document.querySelector('.profile-picture').src = result.image_url;
                    }
                }
            } catch (error) {
                console.error('Error uploading profile picture:', error);
            }
        });

        // Handle bio updates
        let bioUpdateTimeout;
        document.querySelector('.profile-bio').addEventListener('input', function(e) {
            clearTimeout(bioUpdateTimeout);
            bioUpdateTimeout = setTimeout(async () => {
                try {
                    const response = await fetch('update_profile.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            bio: e.target.value
                        })
                    });
                    
                    if (!response.ok) {
                        console.error('Error updating bio');
                    }
                } catch (error) {
                    console.error('Error updating bio:', error);
                }
            }, 500);
        });
    </script>
</body>
</html>
