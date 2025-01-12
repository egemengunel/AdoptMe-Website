<?php
require_once '../../includes/db_connect.php';
require_once '../../includes/FilterManager.php';

header('Content-Type: application/json');

try {
    $type = isset($_GET['type']) ? $_GET['type'] : '';

    if (empty($type)) {
        throw new Exception('Type parameter is required');
    }

    $filterManager = new FilterManager($conn);
    $breeds = $filterManager->getBreedsByType($type);

    echo json_encode($breeds);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
}