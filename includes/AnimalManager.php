<?php
class AnimalManager {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    public function getAnimalsByType($type, $limit = null, $search = null) {
        $sql = "SELECT * FROM animals WHERE type = ?";
        
        // Add search conditions if search term is provided
        if ($search) {
            $sql .= " AND (name LIKE ? OR breed LIKE ? OR age LIKE ?)";
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
        $stmt = $this->conn->prepare("SELECT * FROM animals WHERE animal_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
