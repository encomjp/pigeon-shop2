<?php
function loadProducts() {
    $file = __DIR__ . '/data/products.json';
    if (!file_exists($file)) {
        file_put_contents($file, '[]');
    }
    $json = file_get_contents($file);
    return json_decode($json, true) ?: [];
}

function loadOrders() {
    $file = __DIR__ . '/data/orders.json';
    if (!file_exists($file)) {
        file_put_contents($file, '[]');
    }
    $json = file_get_contents($file);
    return json_decode($json, true) ?: [];
}

function saveOrders($orders) {
    $file = __DIR__ . '/data/orders.json';
    file_put_contents($file, json_encode($orders, JSON_PRETTY_PRINT));
}
?>
