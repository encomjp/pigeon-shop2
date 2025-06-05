<?php
session_start();
require_once __DIR__.'/../helpers.php';
$products = loadProducts();
$id = (int)($_POST['id'] ?? 0);
$product = null;
foreach ($products as $p) {
    if ($p['id'] == $id) { $product = $p; break; }
}
if ($product) {
    if (!isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] = ['product' => $product, 'qty' => 0];
    }
    $_SESSION['cart'][$id]['qty']++;
}
header('Location: /bestellung/cart.php');
exit;
?>
