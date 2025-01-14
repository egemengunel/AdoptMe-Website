<?php
class AnimalManager {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    public function getAnimalsByType($type, $limit = null, $search = null) {
        $sql = "SELECT a.*, ai.image_url 
                FROM animals a 
                LEFT JOIN animal_images ai ON a.animal_id = ai.animal_id 
                WHERE a.type = ? AND ai.is_primary = TRUE";
        
        // Add search conditions if search term is provided
        if ($search) {
            $sql .= " AND (a.name LIKE ? OR a.breed LIKE ? OR a.age LIKE ?)";
        }
        
        // Add limit if provided
        if ($limit) {
            $sql .= " LIMIT ?";
        }
        
        $stmt = $this->conn->prepare($sql);
        
        // Bind parameters based on what's provided
        if ($search && $limit) {
            $searchTerm = "%$search%";
            $stmt->bind_param("ssssi", $type, $searchTerm, $searchTerm, $searchTerm, $limit);
        } elseif ($search) {
            $searchTerm = "%$search%";
            $stmt->bind_param("ssss", $type, $searchTerm, $searchTerm, $searchTerm);
        } elseif ($limit) {
            $stmt->bind_param("si", $type, $limit);
        } else {
            $stmt->bind_param("s", $type);
        }
        
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getAnimalById($id) {
        $stmt = $this->conn->prepare("
            SELECT a.*, ai.image_url 
            FROM animals a 
            LEFT JOIN animal_images ai ON a.animal_id = ai.animal_id 
            WHERE a.animal_id = ? AND ai.is_primary = TRUE
        ");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    
    public function searchAnimals($searchTerm, $type) {
        $searchTerm = $this->conn->real_escape_string($searchTerm);
        $type = $this->conn->real_escape_string($type);
        
        $sql = "SELECT a.*, ai.image_url 
                FROM animals a
                LEFT JOIN animal_images ai ON a.animal_id = ai.animal_id 
                WHERE ai.is_primary = 1 
                AND a.type = ?
                AND (a.name LIKE ? OR a.breed LIKE ? OR a.age LIKE ?)";
                
        $stmt = $this->conn->prepare($sql);
        $searchPattern = "%$searchTerm%";
        $stmt->bind_param('ssss', $type, $searchPattern, $searchPattern, $searchPattern);
        $stmt->execute();
        
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
