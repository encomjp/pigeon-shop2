<?php
// Database connection settings for MAMP (default settings)
$host = 'localhost';
$db_name = 'agil_shop';
$username = 'root';
$password = 'root'; // Default MAMP password
$port = 3306; // Standard MySQL port (8889 is for phpMyAdmin interface)

// Create connection
try {
    $pdo = new PDO(
        "mysql:host=$host;port=$port;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
    
    // Check if database exists, if not create it
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db_name` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdo->exec("USE `$db_name`");
    
    // Connected successfully
    
} catch(PDOException $e) {
    // Log error for debugging
    error_log("Database connection failed: " . $e->getMessage());
    
    // Return user-friendly error
    http_response_code(500);
    if (headers_sent() === false) {
        header('Content-Type: application/json');
    }
    echo json_encode([
        'error' => true,
        'message' => 'Datenbankverbindung fehlgeschlagen. Bitte versuchen Sie es später erneut.'
    ]);
    exit;
}
?>