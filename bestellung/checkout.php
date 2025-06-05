<?php
session_start();
require_once __DIR__.'/../helpers.php';
$cart = $_SESSION['cart'] ?? [];
if (!$cart) { header('Location: cart.php'); exit; }

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $payment = $_POST['payment'] ?? 'per-post';
    $card    = $_POST['card_number'] ?? '';
    if ($payment === 'kreditkarte' && !preg_match('/^\d{16}$/', $card)) {
        $error = 'Bitte eine gültige Kreditkartennummer eingeben.';
    } else {
        $orders = loadOrders();
        $orderId = count($orders) + 1;
        $orders[] = [
            'id' => $orderId,
            'customer' => [
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'street' => $_POST['street'],
                'house_number' => $_POST['house_number'],
                'zip' => $_POST['zip'],
                'city' => $_POST['city']
            ],
            'payment' => ['type' => $payment, 'card_number' => $payment === 'kreditkarte' ? $card : null],
            'items' => $cart,
            'status' => 'In Bearbeitung'
        ];
        saveOrders($orders);
        $_SESSION['cart'] = [];
        header('Location: order-confirmation.php?id='.$orderId);
        exit;
    }
}
$title = 'Kasse';
ob_start();
?>
<h1>Kasse</h1>
<form method="post" data-autosave="true">
  <?php if ($error): ?>
    <p style="color:red;"><?= htmlspecialchars($error) ?></p>
  <?php endif; ?>
  <label>Name
    <input type="text" name="name" required>
  </label>
  <label>Email
    <input type="email" name="email" required>
  </label>
  <label>Straße
    <input type="text" name="street" required>
  </label>
  <label>Hausnummer
    <input type="text" name="house_number" required>
  </label>
  <label>PLZ
    <input type="text" name="zip" required>
  </label>
  <label>Stadt
    <input type="text" name="city" required>
  </label>
  <label>Zahlungsart
    <select name="payment" id="payment-select">
      <option value="per-post">Per Post</option>
      <option value="kreditkarte">Kreditkarte</option>
    </select>
  </label>
  <div id="credit-card" style="display:none;">
    <label>Kreditkartennummer
      <input type="text" name="card_number" pattern="\d{16}">
    </label>
  </div>
  <p><a class="button" href="cart.php">Zurück zum Warenkorb</a></p>
  <button type="submit">Bestellung abschicken</button>
</form>
<?php
$content = ob_get_clean();
include __DIR__.'/../app.php';
?>
