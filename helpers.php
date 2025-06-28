<?php
function loadProducts() {
    $file = __DIR__ . '/data/products.json';
    $json = file_get_contents($file);
    return json_decode($json, true) ?: [];
}

function loadOrders() {
    $file = __DIR__ . '/data/orders.json';
    $json = file_get_contents($file);
    return json_decode($json, true) ?: [];
}

function saveOrders($orders) {
    $file = __DIR__ . '/data/orders.json';
    if (!is_dir(dirname($file))) {
        mkdir(dirname($file), 0755, true);
    }
    $result = file_put_contents($file, json_encode($orders, JSON_PRETTY_PRINT));
    if ($result === false) {
        error_log("Failed to save orders to: " . $file);
        throw new Exception("Bestellung konnte nicht gespeichert werden. Bitte versuchen Sie es erneut.");
    }
}
?>
