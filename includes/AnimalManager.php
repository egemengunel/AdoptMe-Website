<?php
class AnimalManager {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    public function getAnimalsByType($type, $limit = null) {
        $sql = "SELECT * FROM animals WHERE type = ?";
        if ($limit) {
            $sql .= " LIMIT ?";
        }
        
        $stmt = $this->conn->prepare($sql);
        
        if ($limit) {
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
