<?php
session_start();
require_once __DIR__.'/../helpers.php';
$cart = $_SESSION['cart'] ?? [];
if (!$cart) { header('Location: cart.php'); exit; }
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orders = loadOrders();
    $orderId = count($orders) + 1;
    $orders[] = [
        'id' => $orderId,
        'customer' => [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'address' => $_POST['address']
        ],
        'items' => $cart
    ];
    saveOrders($orders);
    $_SESSION['cart'] = [];
    header('Location: order-confirmation.php?id='.$orderId);
    exit;
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
  <label>Adresse
    <textarea name="address" required></textarea>
  </label>
  <button type="submit">Bestellung abschicken</button>
</form>
<?php
$content = ob_get_clean();
include __DIR__.'/../app.php';
?>
