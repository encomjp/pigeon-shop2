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
<h1>Bestellung verfolgen</h1>
<form method="post">
  <label>Bestellnummer
    <input type="number" name="id" required>
  </label>
  <button type="submit">Suchen</button>
</form>
<?php if ($result): ?>
<p>Bestellung von <?= htmlspecialchars($result['customer']['name']) ?> gefunden.</p>
<p>Adresse: <?= htmlspecialchars($result['customer']['street']) ?> <?= htmlspecialchars($result['customer']['house_number']) ?>, <?= htmlspecialchars($result['customer']['zip']) ?> <?= htmlspecialchars($result['customer']['city']) ?></p>
<p>Zahlungsart: <?= htmlspecialchars($result['payment']['type']) ?></p>
<h2>Produkte</h2>
<ul>
  <?php foreach ($result['items'] as $item): ?>
    <li><?= htmlspecialchars($item['product']['name']) ?> x <?= $item['qty'] ?></li>
  <?php endforeach; ?>
</ul>
<p>Status: <strong><?= htmlspecialchars($result['status'] ?? 'Unbekannt') ?></strong></p>
<?php elseif($_SERVER['REQUEST_METHOD']==='POST'): ?>
<p>Keine Bestellung gefunden.</p>
<?php endif; ?>
</div>
<?php include __DIR__.'/../footer.php'; ?>
<script src="/js/main.js"></script>
</body>
</html>
