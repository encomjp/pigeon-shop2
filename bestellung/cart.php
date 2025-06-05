<?php
session_start();
$cart = $_SESSION['cart'] ?? [];
$title = 'Warenkorb';
ob_start();
?>
<h1>Warenkorb</h1>
<?php if (!$cart): ?>
<p>Der Warenkorb ist leer.</p>
<?php else: ?>
<?php $sum = 0; foreach ($cart as $item): $sum += $item['product']['price']*$item['qty']; ?>
  <div class="cart-item">
    <?= htmlspecialchars($item['product']['name']) ?> x <?= $item['qty'] ?> - €<?= number_format($item['product']['price']*$item['qty'],2) ?>
    <a href="remove_from_cart.php?id=<?= $item['product']['id'] ?>">Entfernen</a>
  </div>
<?php endforeach; ?>
<p><strong>Gesamt: €<?= number_format($sum,2) ?></strong></p>
<a href="checkout.php">Zur Kasse</a>
<?php endif; ?>
<?php
$content = ob_get_clean();
include __DIR__.'/../app.php';
?>
