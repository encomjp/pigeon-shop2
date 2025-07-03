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
<title><?= htmlspecialchars($title) ?></title> <!-- Titel der Seite, wird in der Browser-Registerkarte angezeigt -->
<link rel="stylesheet" href="/css/style.css"> <!-- Link zur CSS Datei für das Styling der Seite -->
</head>
<body>
<?php include __DIR__.'/header.php'; ?> <!-- Header der Webseite, enthält Navigation, Logo etc. -->
<div class="container"> <!-- Container über inhalt der webseite -->
<h1>Produkte</h1>
  <!-- Diese PHP Schleife durchläuft alle Produkte und zeigt deren Name, Beschreibung und Preis an. 
       Jedes Produkt hat auch ein Formular, um es in den Warenkorb zu legen. -->
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

</div>
<?php include __DIR__.'/footer.php'; ?>
<script src="/js/main.js"></script>
</body>
</html>
