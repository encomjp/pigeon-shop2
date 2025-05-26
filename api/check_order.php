<?php
// Set headers for JSON response
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");

// Include database connection
require_once '../config/db_connect.php';

// Get transaction ID from parameters
$transaction_id = isset($_GET['transaction_id']) ? trim($_GET['transaction_id']) : null;

if (!$transaction_id) {
    http_response_code(400);
    echo json_encode([
        "error" => true,
        "message" => "Transaktions-ID ist erforderlich"
    ]);
    exit;
}

// Validate transaction ID format
if (!preg_match('/^TR-[A-F0-9]{16}$/', $transaction_id)) {
    http_response_code(400);
    echo json_encode([
        "error" => true,
        "message" => "Ungültiges Transaktions-ID Format"
    ]);
    exit;
}

try {
    // Query to get order details
    $stmt = $pdo->prepare("
        SELECT o.id, o.transaction_id, o.customer_name, o.customer_email, 
               o.total_amount, o.status, o.created_at
        FROM orders o
        WHERE o.transaction_id = ?
    ");
    
    $stmt->execute([$transaction_id]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$order) {
        http_response_code(404);
        echo json_encode([
            "error" => true,
            "message" => "Bestellung nicht gefunden"
        ]);
        exit;
    }
    
    // Get order items
    $stmt = $pdo->prepare("
        SELECT oi.product_id, oi.quantity, oi.price, p.name, p.image_url, p.category
        FROM order_items oi
        JOIN products p ON oi.product_id = p.id
        WHERE oi.order_id = ?
    ");
    
    $stmt->execute([$order['id']]);
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Add items to order response
    $order['items'] = $items;
    
    // Format created_at for better readability
    $order['order_date'] = date('d.m.Y H:i', strtotime($order['created_at']));
    
    // Return order details
    echo json_encode([
        "success" => true,
        "order" => $order
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "error" => true,
        "message" => "Fehler beim Abrufen der Bestellung: " . $e->getMessage()
    ]);
}
?>