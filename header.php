<header>
  <div class="container">
    <a href="/index.php"><img src="https://placehold.co/150x40?text=Pigeon+Shop" alt="Pigeon Shop" style="height:40px;vertical-align:middle"></a>
    <a href="/index.php">Startseite</a>
    <?php
      $cartCount = 0;
      if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
          $cartCount += $item['qty'];
        }
      }
    ?>
    <a href="/bestellung/cart.php">Warenkorb (<?= $cartCount ?>)</a>
    <a href="/bestellung/order-tracking.php">Bestellung verfolgen</a>
  </div>
</header>
