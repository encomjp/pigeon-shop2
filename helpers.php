<?php
// Hilfsfunktionen für das Pigeon Shop System

// Funktion zum Laden der Produktdaten aus JSON-Datei
function loadProducts() {
    $file = __DIR__ . '/data/products.json';
    $json = file_get_contents($file);
    return json_decode($json, true) ?: [];
}

// Funktion zum Laden der Bestelldaten aus JSON-Datei
function loadOrders() {
    $file = __DIR__ . '/data/orders.json'; // Pfad zur JSON-Datei
    $json = file_get_contents($file); // Lese den Inhalt der Datei
    return json_decode($json, true) ?: []; // Wenn die Datei leer ist, gebe ein leeres Array zurück oder dekodiere den Inhalt als Array
}

// Funktion zum Speichern der Bestelldaten in JSON-Datei
function saveOrders($orders) {
    $file = __DIR__ . '/data/orders.json';
    // Überprüfe und erstelle Verzeichnis falls nötig
    if (!is_dir(dirname($file))) {
        mkdir(dirname($file), 0755, true);
    }
    $result = file_put_contents($file, json_encode($orders, JSON_PRETTY_PRINT)); // Speichere die Bestellungen in der Datei
    if ($result === false) { // Fehlerbehandlung
        error_log("Failed to save orders to: " . $file); // Logge den Fehler 
        throw new Exception("Bestellung konnte nicht gespeichert werden. Bitte versuchen Sie es erneut."); // Wirf eine Ausnahme
    }
}
?>
