<?php
// Set headers for JSON response
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");

// Include database connection
require_once '../config/db_connect.php';

try {
    $category = isset($_GET['category']) ? trim($_GET['category']) : null;
    $product_id = isset($_GET['id']) ? intval($_GET['id']) : null;
    
    // Validate product ID if provided
    if ($product_id !== null && $product_id <= 0) {
        throw new Exception("Ungültige Produkt-ID", 400);
    }
    
    // Validate category if provided
    $allowed_categories = ['photos', 'merch', 'courses'];
    if ($category !== null && !in_array($category, $allowed_categories)) {
        throw new Exception("Ungültige Kategorie", 400);
    }
    
    // Build query based on parameters
    if ($product_id) {
        // Get specific product by ID
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$product_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$result) {
            http_response_code(404);
            echo json_encode([
                "error" => true,
                "message" => "Produkt nicht gefunden"
            ]);
            exit;
        }
        
        echo json_encode($result);
    } else if ($category) {
        // Get products by category
        $stmt = $pdo->prepare("SELECT * FROM products WHERE category = ? ORDER BY created_at DESC");
        $stmt->execute([$category]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode($results);
    } else {
        // Get all products
        $stmt = $pdo->query("SELECT * FROM products ORDER BY category, created_at DESC");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode($results);
    }
} catch (Exception $e) {
    $code = $e->getCode() ? $e->getCode() : 500;
    http_response_code($code);
    echo json_encode([
        "error" => true,
        "message" => $e->getMessage()
    ]);
}
?>