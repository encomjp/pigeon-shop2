<?php
// Warenkorb-Übersichtsseite - zeigt alle hinzugefügten Produkte an
session_start();
$cart = $_SESSION['cart'] ?? [];
$title = 'Warenkorb';
?>
<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars($title) ?></title>
<link rel="stylesheet" href="/css/style.css">
</head>
<body>
<?php include __DIR__.'/../header.php'; ?>
<div class="container">
<h1>Warenkorb</h1>
<?php if (!$cart): ?>
<p>Der Warenkorb ist leer.</p>
<?php else: ?>
<?php 
// Berechne Gesamtsumme und zeige alle Warenkorb-Artikel an
$sum = 0; 
foreach ($cart as $item): 
    $sum += $item['product']['price']*$item['qty']; 
?>
  <div class="cart-item">
    <!-- Produktname, Anzahl und Preis anzeigen -->
    <?= htmlspecialchars($item['product']['name']) ?> x <?= $item['qty'] ?> - €<?= number_format($item['product']['price']*$item['qty'],2) ?>
    <!-- Link zum Entfernen des Produkts aus dem Warenkorb -->
    <a class="button" href="remove_from_cart.php?id=<?= $item['product']['id'] ?>">Entfernen</a>
  </div>
<?php endforeach; ?>
<!-- Gesamtsumme anzeigen -->
<p><strong>Gesamt: €<?= number_format($sum,2) ?></strong></p>
<!-- Link zur Kasse -->
<a class="button" href="checkout.php">Zur Kasse</a>
<?php endif; ?>
</div>
<?php include __DIR__.'/../footer.php'; ?>
<script src="/js/main.js"></script>
</body>
</html>
