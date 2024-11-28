<!-- header.php -->

<div class="header">
    <!-- Header Logo -->
    <div class="header-logo">
        <img src="assets/icons/logo.svg" alt="Website Logo" class="header-logo-icon" width="32" height="32">
        <div class="header-logo-text">AdoptMe</div>
    </div>

    <!-- Navigation Links -->
    <div class="header-nav">
        <a href="index.php" class="nav-item">Home</a>
        <a href="browseAnimals.php?type=dogs" class="nav-item">Dogs</a>
        <a href="browseAnimals.php?type=cats" class="nav-item">Cats</a>
        <a href="favorites.php" class="nav-item">Favorites</a>
    </div>

    <!-- Sign-in/Profile Button -->
    <div class="header-signin">
        <?php if (isset($_SESSION['user'])): ?>
            <div class="profile-button">
                <a href="#" class="user-profile" id="profileTrigger">
                    <?php if (!empty($_SESSION['user']['profile_picture_url'])): ?>
                        <img src="<?php echo htmlspecialchars($_SESSION['user']['profile_picture_url']); ?>" 
                             alt="Profile Picture" 
                             class="profile-pic">
                    <?php endif; ?>
                    <span class="username"><?php echo htmlspecialchars($_SESSION['user']['username']); ?></span>
                </a>
                <div class="profile-dropdown-menu">
                    <a href="profile.php" class="dropdown-item">
                        <img src="assets/icons/profile-icon.svg" alt="Profile" class="icon">
                        <span>Your Profile</span>
                    </a>
                    <a href="favorites.php" class="dropdown-item">
                        <img src="assets/icons/favorites-icon.svg" alt="Favorites" class="icon">
                        <span>Favorites</span>
                    </a>
                    <a href="logout.php" class="dropdown-item">
                        <img src="assets/icons/signout-icon.svg" alt="Sign Out" class="icon">
                        <span>Sign Out</span>
                    </a>
                    <a href="upload.php" class="dropdown-item upload">
                        <img src="assets/icons/upload-icon.svg" alt="Upload" class="icon">
                        <span>Upload An Animal</span>
                    </a>
                </div>
            </div>
        <?php else: ?>
            <a href="auth.php?mode=signin" class="signin-button">
                <span class="signin-text">Sign In</span>
            </a>
        <?php endif; ?>
    </div>
</div>