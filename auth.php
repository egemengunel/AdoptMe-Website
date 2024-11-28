<?php
require_once 'includes/db_connect.php';
require_once 'includes/AuthManager.php';

$auth = new AuthManager($conn);
$mode = $_GET['mode'] ?? 'signin';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($mode === 'signin') {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        
        error_log("Login attempt with email: " . $email);
        
        if ($auth->login($email, $password)) {
            header('Location: index.php');
            exit;
        } else {
            error_log("Login failed for email: " . $email);
            $error = 'Invalid email or password';
        }
    } else {
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        
        if ($auth->register($username, $email, $password)) {
            // Auto login after registration
            $auth->login($email, $password);
            header('Location: index.php');
            exit;
        } else {
            $error = 'Registration failed. Email might already be in use.';
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo ucfirst($mode); ?> - AdoptMe</title>
    <!-- Global Styles -->
    <link rel="stylesheet" href="assets/css/global.css">
    <!-- Text Styles -->
    <link rel="stylesheet" href="assets/css/textStyles.css">
    <!-- Header Styles -->
    <link rel="stylesheet" href="assets/css/header.css">
    <!-- Footer Styles -->
    <link rel="stylesheet" href="assets/css/footer.css">
    <!-- Auth Page Specific Styles -->
    <link rel="stylesheet" href="assets/css/auth.css">
</head>
<body>
    <div class="wrapper">
        <div class="content-wrapper">
            <?php include 'templates/header.php'; ?>
            
            <div class="auth-form-container">
                <div class="auth-form">
                    <h1 class="auth-title"><?php echo $mode === 'signin' ? 'Sign In' : 'Sign Up'; ?></h1>
                    
                    <?php if ($error): ?>
                        <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
                    <?php endif; ?>
                    
                    <div class="form-content">
                        <form method="POST">
                            <?php if ($mode === 'signup'): ?>
                                <div class="form-group">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" id="username" name="username" class="form-input" required>
                                </div>
                            <?php endif; ?>
                            
                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" class="form-input" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id="password" name="password" class="form-input" required>
                            </div>
                            
                            <div class="form-actions">
                                <?php if ($mode === 'signin'): ?>
                                    <a href="?mode=signup" class="alternate-link">Don't have an account? Sign Up</a>
                                <?php else: ?>
                                    <a href="?mode=signin" class="alternate-link">Already have an account? Sign In</a>
                                <?php endif; ?>
                                
                                <button type="submit" class="auth-form-button">
                                    <?php echo $mode === 'signin' ? 'Sign In' : 'Sign Up'; ?>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <?php include 'templates/footer.php'; ?>
    </div>
</body>
</html>