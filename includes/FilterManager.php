<?php
class FilterManager {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    // Get all available filter options based on current animal type
    public function getFilterOptions($animalType = null) {
        return [
            'ages' => $this->getUniqueValues('age', $animalType),
            'breeds' => $this->getUniqueValues('breed', $animalType),
            'colors' => $this->getUniqueValues('color', $animalType),
            'sizes' => $this->getUniqueValues('size', $animalType),
            'genders' => $this->getUniqueValues('gender', $animalType),
            'locations' => $this->getUniqueValues('location', $animalType)
        ];
    }
    
    // Get unique values for a specific column, filtered by animal type
    private function getUniqueValues($column, $animalType = null) {
        $validColumns = ['breed', 'age', 'color', 'location', 'size', 'gender'];
        if (!in_array($column, $validColumns)) {
            return [];
        }

        $sql = "SELECT DISTINCT $column 
                FROM animals 
                WHERE $column IS NOT NULL 
                AND $column != ''";
        
        // Convert URL type to database type
        if ($animalType) {
            $dbType = ($animalType === 'dogs') ? 'dog' : 'cat';
            $sql .= " AND type = '" . $this->conn->real_escape_string($dbType) . "'";
        }
        
        $sql .= " ORDER BY $column";
        
        $result = $this->conn->query($sql);
        
        if (!$result) {
            return [];
        }
        
        $values = [];
        while ($row = $result->fetch_assoc()) {
            $values[] = $row[$column];
        }
        
        return $values;
    }
    
    // Get current filter values from URL
    public function getCurrentFilters() {
        return [
            'type' => $_GET['type'] ?? '',
            'age' => $_GET['age'] ?? '',
            'breed' => $_GET['breed'] ?? '',
            'gender' => $_GET['gender'] ?? '',
            'color' => $_GET['color'] ?? '',
            'size' => $_GET['size'] ?? '',
            'location' => $_GET['location'] ?? ''
        ];
    }
    
    // Get filtered animals
    public function getFilteredAnimals($filters) {
        $conditions = [];
        
        // Convert URL type to database type and add to conditions
        if (!empty($filters['type'])) {
            $dbType = ($filters['type'] === 'dogs') ? 'dog' : 'cat';
            $conditions[] = "a.type = '" . $this->conn->real_escape_string($dbType) . "'";
        }
        
        // Add other filter conditions
        if (!empty($filters['age'])) {
            $conditions[] = "a.age = '" . $this->conn->real_escape_string($filters['age']) . "'";
        }
        if (!empty($filters['breed'])) {
            $conditions[] = "a.breed = '" . $this->conn->real_escape_string($filters['breed']) . "'";
        }
        if (!empty($filters['gender'])) {
            $conditions[] = "a.gender = '" . $this->conn->real_escape_string($filters['gender']) . "'";
        }
        if (!empty($filters['color'])) {
            $conditions[] = "a.color = '" . $this->conn->real_escape_string($filters['color']) . "'";
        }
        if (!empty($filters['size'])) {
            $conditions[] = "a.size = '" . $this->conn->real_escape_string($filters['size']) . "'";
        }
        if (!empty($filters['location'])) {
            $conditions[] = "a.location = '" . $this->conn->real_escape_string($filters['location']) . "'";
        }
        
        // Build the SQL query
        $sql = "SELECT a.*, ai.image_url 
                FROM animals a
                LEFT JOIN animal_images ai ON a.animal_id = ai.animal_id 
                WHERE ai.is_primary = 1";
        
        if (!empty($conditions)) {
            $sql .= " AND " . implode(" AND ", $conditions);
        }
        
        // Execute query
        $result = $this->conn->query($sql);
        
        if (!$result) {
            return [];
        }
        
        // Fetch results
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function hasActiveFilters($filters) {
        // Remove 'type' from consideration as it's always set
        unset($filters['type']);
        
        // Check if any other filters are set
        foreach ($filters as $value) {
            if (!empty($value)) {
                return true;
            }
        }
        return false;
    }
} 