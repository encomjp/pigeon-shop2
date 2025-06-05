<?php
session_start();
require_once __DIR__.'/../helpers.php';
$id = (int)($_GET['id'] ?? 0);
$orders = loadOrders();
$order = null;
foreach ($orders as $o) {
    if ($o['id'] == $id) { $order = $o; break; }
}
$title = 'Bestätigung';
ob_start();
?>
<h1>Bestellung bestätigt</h1>
<?php if ($order): ?>
<p>Vielen Dank, <?= htmlspecialchars($order['customer']['name']) ?>!</p>
<p>Ihre Bestellnummer lautet <?= $order['id'] ?>.</p>
<p>Lieferadresse:<br>
  <?= htmlspecialchars($order['customer']['street']) ?> <?= htmlspecialchars($order['customer']['house_number']) ?><br>
  <?= htmlspecialchars($order['customer']['zip']) ?> <?= htmlspecialchars($order['customer']['city']) ?>
</p>
<p>Zahlungsart: <?= htmlspecialchars($order['payment']['type']) ?></p>
<h2>Produkte</h2>
<ul>
  <?php foreach ($order['items'] as $item): ?>
    <li><?= htmlspecialchars($item['product']['name']) ?> x <?= $item['qty'] ?></li>
  <?php endforeach; ?>
</ul>
<p>Status: <strong><?= htmlspecialchars($order['status'] ?? 'In Bearbeitung') ?></strong></p>
<?php else: ?>
<p>Bestellung nicht gefunden.</p>
<?php endif; ?>
<a class="button" href="/index.php">Weiter einkaufen</a>
<?php
$content = ob_get_clean();
include __DIR__.'/../app.php';
?>
