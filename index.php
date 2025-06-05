<?php
session_start();
require_once __DIR__.'/helpers.php';
$products = loadProducts();
$title = 'Produkte';
ob_start();
?>
<h1>Produkte</h1>
<?php foreach ($products as $p): ?>
  <div class="product">
    <h3><?= htmlspecialchars($p['name']) ?></h3>
    <p><?= htmlspecialchars($p['description']) ?></p>
    <p>Preis: €<?= number_format($p['price'],2) ?></p>
    <form method="post" action="/bestellung/add_to_cart.php">
      <input type="hidden" name="id" value="<?= $p['id'] ?>">
      <button type="submit">In den Warenkorb</button>
    </form>
  </div>
<?php endforeach; ?>
<?php
$content = ob_get_clean();
include __DIR__.'/app.php';
?>
