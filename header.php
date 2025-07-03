<header>
  <div class="container">
    <!-- Logo und Navigation der Website -->
    <a href="/index.php"><alt="Pigeon Shop" style="height:40px;vertical-align:middle"></a>
    <a href="/index.php">Startseite</a>
    <?php
      $cartCount = 0;
      // Prüfen, ob der Warenkorb in der Session existiert und die Anzahl der Artikel zählen
      if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
          $cartCount += $item['qty'];
        }
      }
    ?>
    <!-- Warenkorb-Link mit aktueller Artikelanzahl -->
    <a href="/bestellung/cart.php">Warenkorb (<?= $cartCount ?>)</a>
    <!-- Link zur Bestellverfolgung -->
    <a href="/bestellung/order-tracking.php">Bestellung verfolgen</a>
  </div>
</header>
