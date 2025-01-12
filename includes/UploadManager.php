<?php
class UploadManager {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function uploadAnimal($data, $images) {
        try {
            $this->conn->beginTransaction();
            
            // Insert animal data
            $stmt = $this->conn->prepare("
                INSERT INTO animals (name, type, breed, age, color, size, gender, location, description)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            
            $stmt->execute([
                $data['name'],
                $data['type'],
                $data['breed'],
                $data['age'],
                $data['color'],
                $data['size'],
                $data['gender'],
                $data['location'],
                $data['description']
            ]);
            
            $animalId = $this->conn->lastInsertId();
            
            // Handle image uploads
            foreach ($images as $index => $image) {
                $imageUrl = $this->saveImage($image);
                $isPrimary = ($index === 0); // First image is primary
                
                $stmt = $this->conn->prepare("
                    INSERT INTO animal_images (animal_id, image_url, is_primary)
                    VALUES (?, ?, ?)
                ");
                $stmt->execute([$animalId, $imageUrl, $isPrimary]);
            }
            
            $this->conn->commit();
            return $animalId;
            
        } catch (Exception $e) {
            $this->conn->rollBack();
            throw $e;
        }
    }
    
    private function saveImage($image) {
        // Implementation for saving image file
        // Return the image URL
    }
} 