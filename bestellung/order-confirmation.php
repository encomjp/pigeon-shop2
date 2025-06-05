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
<p>Wir versenden an:<br>
<?= htmlspecialchars($order['customer']['street']) ?> <?= htmlspecialchars($order['customer']['house_number']) ?><br>
<?= htmlspecialchars($order['customer']['city']) ?></p>
<p>Zahlungsart: <?= htmlspecialchars($order['customer']['payment']) ?></p>
<?php else: ?>
<p>Bestellung nicht gefunden.</p>
<?php endif; ?>
<a href="/index.php">Weiter einkaufen</a>
<?php
$content = ob_get_clean();
include __DIR__.'/../app.php';
?>
