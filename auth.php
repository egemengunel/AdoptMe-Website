<?php
// auth.php

// Determine the mode (signin or signup)
$mode = isset($_GET['mode']) ? $_GET['mode'] : 'signin';

// Set variables based on the mode
if ($mode === 'signup') {
    $title = 'Create Your Account';
    $form_action = 'process_signup.php';
    $button_text = 'Sign Up';
    $alternate_text = 'or Sign In';
    $alternate_link = 'auth.php?mode=signin';
    $show_confirm_password = true; // Set to true if you want to include confirm password field
} else {
    $title = 'Welcome Back 👋';
    $form_action = 'process_signin.php';
    $button_text = 'Sign In';
    $alternate_text = 'or Create a New Account';
    $alternate_link = 'auth.php?mode=signup';
    $show_confirm_password = false;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo ($mode === 'signup') ? 'Sign Up' : 'Sign In'; ?> - AdoptMe</title>
    <link rel="stylesheet" href="assets/css/global.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="assets/css/auth.css">
    <link rel="stylesheet" href="assets/css/textStyles.css">
</head>
<body>
    <div class="wrapper">
        <!-- Header -->
        <?php include 'templates/header.php'; ?>

        <!-- Main Content -->
        <div class="content-wrapper">
            <div class="content-container">
                <!-- Auth Form -->
                <div class="auth-form-container">
                    <div class="auth-form">
                        <h1 class="auth-title"><?php echo $title; ?></h1>

                        <form action="<?php echo $form_action; ?>" method="POST">
                            <div class="form-content">
                                <!-- Email Field -->
                                <div class="form-group">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" id="email" name="email" class="form-input" required>
                                </div>

                                <!-- Password Field -->
                                <div class="form-group">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" id="password" name="password" class="form-input" required>
                                </div>

                                <?php if ($show_confirm_password): ?>
                                <!-- Confirm Password Field -->
                                <div class="form-group">
                                    <label for="confirm_password" class="form-label">Confirm Password</label>
                                    <input type="password" id="confirm_password" name="confirm_password" class="form-input" required>
                                </div>
                                <?php endif; ?>

                                <!-- Form Actions -->
                                <div class="form-actions">
                                    <a href="<?php echo $alternate_link; ?>" class="alternate-link"><?php echo $alternate_text; ?></a>
                                    <button type="submit" class="auth-form-button"><?php echo $button_text; ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <?php include 'templates/footer.php'; ?>
    </div>
</body>
</html>