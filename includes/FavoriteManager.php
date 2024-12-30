<?php
class FavoriteManager {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    public function toggleFavorite($userId, $animalId) {
        // Check if already favorited
        $checkStmt = $this->conn->prepare("
            SELECT favorite_id FROM favorites 
            WHERE user_id = ? AND animal_id = ?
        ");
        $checkStmt->bind_param("ii", $userId, $animalId);
        $checkStmt->execute();
        $result = $checkStmt->get_result();

        if ($result->num_rows > 0) {
            // If exists, remove from favorites
            $deleteStmt = $this->conn->prepare("
                DELETE FROM favorites 
                WHERE user_id = ? AND animal_id = ?
            ");
            $deleteStmt->bind_param("ii", $userId, $animalId);
            $deleteStmt->execute();
            return false; // Indicates removed from favorites
        } else {
            // If doesn't exist, add to favorites
            $insertStmt = $this->conn->prepare("
                INSERT INTO favorites (user_id, animal_id) 
                VALUES (?, ?)
            ");
            $insertStmt->bind_param("ii", $userId, $animalId);
            $insertStmt->execute();
            return true; // Indicates added to favorites
        }
    }
    
    public function getFavorites($userId) {
        $stmt = $this->conn->prepare("
            SELECT a.*, ai.image_url 
            FROM animals a
            JOIN favorites f ON a.animal_id = f.animal_id
            LEFT JOIN animal_images ai ON a.animal_id = ai.animal_id
            WHERE f.user_id = ? AND ai.is_primary = TRUE
        ");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    public function isFavorited($userId, $animalId) {
        $stmt = $this->conn->prepare("
            SELECT favorite_id 
            FROM favorites 
            WHERE user_id = ? AND animal_id = ?
        ");
        $stmt->bind_param("ii", $userId, $animalId);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }
} 