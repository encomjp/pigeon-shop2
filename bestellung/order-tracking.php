<?php
session_start();
require_once __DIR__.'/../helpers.php';
$result = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    foreach (loadOrders() as $o) {
        if ($o['id'] == $id) { $result = $o; break; }
    }
}
$title = 'Bestellung verfolgen';
ob_start();
?>
<h1>Bestellung verfolgen</h1>
<form method="post">
  <label>Bestellnummer
    <input type="number" name="id" required>
  </label>
  <button type="submit">Suchen</button>
</form>
<?php if ($result): ?>
<p>Bestellung von <?= htmlspecialchars($result['customer']['name']) ?> gefunden.</p>
<p>Adresse: <?= htmlspecialchars($result['customer']['street']) ?> <?= htmlspecialchars($result['customer']['house_number']) ?>, <?= htmlspecialchars($result['customer']['city']) ?></p>
<p>Zahlungsart: <?= htmlspecialchars($result['customer']['payment']) ?></p>
<?php elseif($_SERVER['REQUEST_METHOD']==='POST'): ?>
<p>Keine Bestellung gefunden.</p>
<?php endif; ?>
<?php
$content = ob_get_clean();
include __DIR__.'/../app.php';
?>
