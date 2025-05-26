<?php
// Set headers for JSON response
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Include database connection
require_once '../config/db_connect.php';

// Only allow POST requests for this endpoint
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405); // Method Not Allowed
    echo json_encode([
        "error" => true,
        "message" => "Nur POST-Anfragen sind erlaubt"
    ]);
    exit;
}

// Get POST data (JSON)
$json_data = file_get_contents("php://input");
$data = json_decode($json_data, true);

// Validate request data
if (!$data || !isset($data['customer']) || !isset($data['items']) || empty($data['items'])) {
    http_response_code(400); // Bad Request
    echo json_encode([
        "error" => true,
        "message" => "Ungültige Anfragedaten"
    ]);
    exit;
}

// Validate customer data
$required_fields = ['name', 'email', 'address'];
foreach ($required_fields as $field) {
    if (!isset($data['customer'][$field]) || trim($data['customer'][$field]) === '') {
        http_response_code(400);
        echo json_encode([
            "error" => true,
            "message" => "Fehlende Kundendaten: $field"
        ]);
        exit;
    }
}

// Validate email format
if (!filter_var($data['customer']['email'], FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode([
        "error" => true,
        "message" => "Ungültige E-Mail-Adresse"
    ]);
    exit;
}

try {
    // Start transaction
    $pdo->beginTransaction();
    
    // Generate a unique transaction ID
    $transaction_id = 'TR-' . strtoupper(bin2hex(random_bytes(8)));
    
    // Validate and calculate the total amount
    $total_amount = 0;
    foreach ($data['items'] as $item) {
        // Validate item data
        if (!isset($item['id'], $item['price'], $item['quantity']) || 
            $item['quantity'] <= 0 || $item['price'] < 0) {
            throw new Exception("Ungültige Artikeldaten");
        }
        
        // Verify product exists in database
        $stmt = $pdo->prepare("SELECT price FROM products WHERE id = ?");
        $stmt->execute([$item['id']]);
        $product = $stmt->fetch();
        
        if (!$product) {
            throw new Exception("Produkt ID {$item['id']} nicht gefunden");
        }
        
        // Use database price instead of client-sent price for security
        $total_amount += $product['price'] * $item['quantity'];
    }
    
    // Add shipping cost (if applicable)
    if (isset($data['shipping_cost']) && $data['shipping_cost'] > 0) {
        $total_amount += $data['shipping_cost'];
    }
    
    // Insert into orders table
    $stmt = $pdo->prepare("
        INSERT INTO orders 
        (transaction_id, customer_name, customer_email, customer_address, total_amount, status)
        VALUES (?, ?, ?, ?, ?, 'Bearbeitung')
    ");
    
    $stmt->execute([
        $transaction_id,
        trim($data['customer']['name']),
        trim($data['customer']['email']),
        trim($data['customer']['address']),
        $total_amount
    ]);
    
    $order_id = $pdo->lastInsertId();
    
    // Insert order items with validated data
    $stmt = $pdo->prepare("
        INSERT INTO order_items
        (order_id, product_id, quantity, price)
        VALUES (?, ?, ?, ?)
    ");
    
    foreach ($data['items'] as $item) {
        // Get actual price from database
        $price_stmt = $pdo->prepare("SELECT price FROM products WHERE id = ?");
        $price_stmt->execute([$item['id']]);
        $product = $price_stmt->fetch();
        
        $stmt->execute([
            $order_id,
            $item['id'],
            $item['quantity'],
            $product['price']
        ]);
    }
    
    // Commit the transaction
    $pdo->commit();
    
    // Return success response with transaction ID
    echo json_encode([
        "success" => true,
        "message" => "Bestellung erfolgreich aufgegeben",
        "transaction_id" => $transaction_id,
        "order_id" => $order_id,
        "total_amount" => $total_amount
    ]);
    
} catch (Exception $e) {
    // Rollback transaction on error
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    
    // Return error response
    http_response_code(500);
    echo json_encode([
        "error" => true,
        "message" => "Fehler bei der Verarbeitung der Bestellung: " . $e->getMessage()
    ]);
}
?>