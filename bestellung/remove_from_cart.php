<?php
// Entfernt Produkte aus dem Warenkorb
session_start();

// Hole die Produkt-ID aus dem GET-Parameter
$id = (int)($_GET['id'] ?? 0);

// Entferne das Produkt aus dem Warenkorb falls vorhanden
if (isset($_SESSION['cart'][$id])) {
    unset($_SESSION['cart'][$id]);
}

// Weiterleitung zurück zur Warenkorb-Seite
header('Location: cart.php');
exit;
?>
