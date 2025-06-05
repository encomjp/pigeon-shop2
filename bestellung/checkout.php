<?php
session_start();
require_once __DIR__.'/../helpers.php';
$cart = $_SESSION['cart'] ?? [];
if (!$cart) { header('Location: cart.php'); exit; }
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $payment = $_POST['payment'] ?? '';
    $validPayments = ['per-post', 'kreditkarte'];
    if (!in_array($payment, $validPayments)) {
        $error = 'Ungültige Zahlungsmethode';
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
                'city' => $_POST['city'],
                'payment' => $payment
            ],
            'items' => $cart
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
<form method="post">
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
  <label>Stadt
    <input type="text" name="city" required>
  </label>
  <label>Zahlungsart
    <select name="payment" required>
      <option value="per-post">Per Post</option>
      <option value="kreditkarte">Kreditkarte</option>
    </select>
  </label>
  <button type="submit">Bestellung abschicken</button>
  <?php if ($error): ?>
    <p style="color:red;"><?= htmlspecialchars($error) ?></p>
  <?php endif; ?>
</form>
<?php
$content = ob_get_clean();
include __DIR__.'/../app.php';
?>
