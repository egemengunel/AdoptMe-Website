<?php
session_start();

require_once 'includes/AuthManager.php';
require_once 'includes/db_connect.php';

// Initialize the auth manager with database connection
$auth = new AuthManager($conn);

// Check authentication
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['user_id']) || !$auth->isLoggedIn()) {
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
        // Delete old profile picture if exists
        if (!empty($_SESSION['user']['profile_picture_url']) && file_exists($_SESSION['user']['profile_picture_url'])) {
            unlink($_SESSION['user']['profile_picture_url']);
        }

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
            exit();
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Database error']);
            exit();
        }
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to upload file']);
        exit();
    }
}

// Handle text updates (username and bio)
$data = json_decode(file_get_contents('php://input'), true);

if ($data && (isset($data['username']) || isset($data['bio']))) {
    $updates = [];
    $types = "";
    $params = [];

    if (isset($data['username']) && !empty($data['username'])) {
        // Validate username
        if (strlen($data['username']) < 3) {
            http_response_code(400);
            echo json_encode(['error' => 'Username must be at least 3 characters long']);
            exit();
        }
        $updates[] = "username = ?";
        $types .= "s";
        $params[] = $data['username'];
    }

    if (isset($data['bio'])) {
        $updates[] = "bio = ?";
        $types .= "s";
        $params[] = $data['bio'];
    }

    if (!empty($updates)) {
        $params[] = $userId;
        $types .= "i";

        $sql = "UPDATE users SET " . implode(", ", $updates) . " WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        
        if ($stmt->execute()) {
            // Update session data
            if (isset($data['username'])) {
                $_SESSION['user']['username'] = $data['username'];
            }
            
            echo json_encode(['success' => true]);
            exit();
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Database error']);
            exit();
        }
    }
}

// If we get here, no valid action was performed
http_response_code(400);
echo json_encode(['error' => 'Invalid request']);
?> 