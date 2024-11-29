<?php
require_once 'includes/AuthManager.php';
require_once 'includes/db_connect.php';

// Initialize the auth manager with database connection
$auth = new AuthManager($conn);

// Check if user is logged in
if (!$auth->isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

$userId = $_SESSION['user']['user_id'];

// Handle profile picture upload
if (isset($_FILES['profile_picture'])) {
    $uploadDir = 'uploads/profile_pictures/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileExtension = strtolower(pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION));
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

    if (!in_array($fileExtension, $allowedExtensions)) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid file type']);
        exit();
    }

    $fileName = uniqid('profile_') . '.' . $fileExtension;
    $targetPath = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $targetPath)) {
        // Update database with new profile picture path
        $stmt = $conn->prepare("UPDATE users SET profile_picture_url = ? WHERE user_id = ?");
        $stmt->bind_param("si", $targetPath, $userId);
        
        if ($stmt->execute()) {
            // Update session with new profile picture URL
            $_SESSION['user']['profile_picture_url'] = $targetPath;
            
            echo json_encode([
                'success' => true,
                'image_url' => $targetPath
            ]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Database error']);
        }
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to upload file']);
    }
}

// Handle bio update
$data = json_decode(file_get_contents('php://input'), true);
if (isset($data['bio'])) {
    $stmt = $conn->prepare("UPDATE users SET bio = ? WHERE user_id = ?");
    $stmt->bind_param("si", $data['bio'], $userId);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Database error']);
    }
}
?> 