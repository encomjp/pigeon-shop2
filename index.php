<?php
session_start();
require_once __DIR__.'/helpers.php';
$products = loadProducts();
$title = 'Produkte';
?>
<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars($title) ?></title>
<link rel="stylesheet" href="/css/style.css">
</head>
<body>
<?php include __DIR__.'/header.php'; ?>
<div class="container">
<h1>Produkte</h1>
<?php foreach ($products as $p): ?>
  <div class="product">
    <?php $img = !empty($p['image']) ? $p['image'] : '/assets/placeholder.jpg'; ?>
    <img src="<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($p['name']) ?>">
    <h3><?= htmlspecialchars($p['name']) ?></h3>
    <p><?= htmlspecialchars($p['description']) ?></p>
    <p>Preis: €<?= number_format($p['price'],2) ?></p>
    <form method="post" action="/bestellung/add_to_cart.php">
      <input type="hidden" name="id" value="<?= $p['id'] ?>">
      <button type="submit">In den Warenkorb</button>
    </form>
  </div>
<?php endforeach; ?>
</div>
<?php include __DIR__.'/footer.php'; ?>
<script src="/js/main.js"></script>
</body>
</html>
