<?php
// Include database connection
require_once 'db_connect.php';

try {
    // First, check if tables exist and get their structure
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    
    // Create or update products table
    if (!in_array('products', $tables)) {
        $pdo->exec("CREATE TABLE `products` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `name` VARCHAR(255) NOT NULL,
            `description` TEXT,
            `price` DECIMAL(10,2) NOT NULL,
            `image_url` VARCHAR(500),
            `category` VARCHAR(100) NOT NULL,
            `stock_quantity` INT DEFAULT 0,
            `is_active` BOOLEAN DEFAULT TRUE,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX `idx_category` (`category`),
            INDEX `idx_active` (`is_active`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
        echo "✅ Products table created\n";
    } else {
        // Check if stock_quantity column exists, if not add it
        $columns = $pdo->query("SHOW COLUMNS FROM products")->fetchAll(PDO::FETCH_COLUMN);
        if (!in_array('stock_quantity', $columns)) {
            $pdo->exec("ALTER TABLE products ADD COLUMN stock_quantity INT DEFAULT 0");
            echo "✅ Added stock_quantity column to products table\n";
        }
        if (!in_array('is_active', $columns)) {
            $pdo->exec("ALTER TABLE products ADD COLUMN is_active BOOLEAN DEFAULT TRUE");
            echo "✅ Added is_active column to products table\n";
        }
        echo "✅ Products table updated\n";
    }

    // Create orders table
    if (!in_array('orders', $tables)) {
        $pdo->exec("CREATE TABLE `orders` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `transaction_id` VARCHAR(50) NOT NULL UNIQUE,
            `customer_name` VARCHAR(255) NOT NULL,
            `customer_email` VARCHAR(255) NOT NULL,
            `customer_address` TEXT NOT NULL,
            `customer_phone` VARCHAR(50),
            `total_amount` DECIMAL(10,2) NOT NULL,
            `status` ENUM('Bearbeitung', 'Bestätigt', 'Versandt', 'Geliefert', 'Storniert') DEFAULT 'Bearbeitung',
            `payment_status` ENUM('Ausstehend', 'Bezahlt', 'Fehlgeschlagen') DEFAULT 'Ausstehend',
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX `idx_transaction` (`transaction_id`),
            INDEX `idx_status` (`status`),
            INDEX `idx_email` (`customer_email`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
        echo "✅ Orders table created\n";
    }

    // Create order_items table
    if (!in_array('order_items', $tables)) {
        $pdo->exec("CREATE TABLE `order_items` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `order_id` INT NOT NULL,
            `product_id` INT NOT NULL,
            `quantity` INT NOT NULL CHECK (`quantity` > 0),
            `price` DECIMAL(10,2) NOT NULL CHECK (`price` >= 0),
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
            FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE RESTRICT,
            INDEX `idx_order` (`order_id`),
            INDEX `idx_product` (`product_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
        echo "✅ Order items table created\n";
    }

    // Insert sample products if none exist
    $count = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
    
    if ($count == 0) {
        $products = [
            // Taubenfotos (Pigeon Photos)
            ['Majestätische Stadttaube', 'Eine beeindruckende Taube mit Blick über die Stadt. Hochauflösendes Foto im Format 30x40cm.', 15.99, '/assets/images/city-pigeon.jpg', 'photos', 50],
            ['Fliegende Schönheit', 'Eine Taube im eleganten Flug über einen Park. Perfekt für Wanddekoration.', 19.99, '/assets/images/fliegende-schoenheit.jpg', 'photos', 30],
            ['Tauben-Portrait', 'Nahaufnahme einer Taube mit beeindruckenden Details des Gefieders. Limitierte Edition.', 12.99, '/assets/images/tauben-portrait.jpg', 'photos', 25],
            
            // Tauben Merch (Pigeon Merchandise)
            ['Tauben Power T-Shirt', 'Zeigen Sie Ihre Taubenliebe mit diesem stylischen Shirt. 100% Baumwolle, Größe: L', 24.95, '/assets/images/tshirt.jpg', 'merch', 20],
            ['Tauben Kaffeetasse', 'Starten Sie Ihren Tag mit dieser eleganten Tauben-Motiv Tasse. Spülmaschinenfest.', 14.95, '/assets/images/tauben-kaffeetasse.jpg', 'merch', 15],
            ['Tauben Schlüsselanhänger', 'Ein praktischer Begleiter für jeden Taubenliebhaber. Aus robustem Metall.', 9.95, '/assets/images/tauben-schluesselanhaenger.jpg', 'merch', 40],
            
            // Tauben Kurse (Pigeon Courses)
            ['Taubensprache verstehen', 'Lernen Sie die Grundlagen der Taubenkommunikation mit diesem umfassenden Online-Kurs. 4 Stunden Videomaterial.', 45.00, '/assets/images/taubensprache-verstehen.jpg', 'courses', 100],
            ['Taubenfotografie Meisterkurs', 'Erfassen Sie die Schönheit der Tauben mit professionellen Fotografietechniken. Inkl. E-Book und Presets.', 65.00, '/assets/images/photography-course.jpg', 'courses', 50],
            ['Tauben in der Stadt', 'Ein Online-Kurs über das Zusammenleben von Menschen und Tauben im urbanen Raum. Wissenschaftlich fundiert.', 35.00, '/assets/images/urban-pigeons.jpg', 'courses', 75]
        ];

        $stmt = $pdo->prepare("INSERT INTO products (name, description, price, image_url, category, stock_quantity) VALUES (?, ?, ?, ?, ?, ?)");
        
        foreach ($products as $product) {
            $stmt->execute($product);
        }
        echo "✅ Beispielprodukte erfolgreich zur Datenbank hinzugefügt!\n";
    } else {
        echo "ℹ️ Produkte bereits vorhanden, überspringe Einfügung.\n";
    }

    echo "✅ Datenbank-Setup erfolgreich abgeschlossen!\n";
    echo "📊 Tabellen erstellt: products, orders, order_items\n";
    echo "🔢 Anzahl Produkte in Datenbank: " . $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn() . "\n";

} catch (Exception $e) {
    echo "❌ Fehler beim Datenbank-Setup: " . $e->getMessage() . "\n";
    exit(1);
}
?>