<?php
// Fügt Produkte zum Warenkorb hinzu
session_start();
require_once __DIR__.'/../helpers.php';

// Lade alle verfügbaren Produkte
$products = loadProducts();

// Hole die Produkt-ID aus dem POST-Request
$id = (int)($_POST['id'] ?? 0);
$product = null;

// Suche das Produkt mit der entsprechenden ID
foreach ($products as $p) {
    if ($p['id'] == $id) { 
        $product = $p; 
        break; 
    }
}

// Füge Produkt zum Warenkorb hinzu falls gefunden
if ($product) {
    // Initialisiere Warenkorb-Eintrag falls noch nicht vorhanden
    if (!isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] = ['product' => $product, 'qty' => 0];
    }
    // Erhöhe die Anzahl um 1
    $_SESSION['cart'][$id]['qty']++;
}

// Weiterleitung zur Warenkorb-Seite
header('Location: /bestellung/cart.php');
exit;
?>
