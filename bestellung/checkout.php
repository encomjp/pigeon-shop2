<?php
session_start();
require_once __DIR__.'/../helpers.php';
$cart = $_SESSION['cart'] ?? [];
if (!$cart) { header('Location: cart.php'); exit; }

$error = '';
$debug_info = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $debug_info .= "Form submitted. ";
    $payment = $_POST['payment'] ?? 'per-post';
    $card    = preg_replace('/\D/', '', $_POST['card_number'] ?? ''); // Remove non-digits
    
    $debug_info .= "Payment method: $payment. ";
    
    // Validate required fields
    $required_fields = ['name', 'email', 'street', 'house_number', 'zip', 'city'];
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $error = "Bitte füllen Sie alle Pflichtfelder aus.";
            $debug_info .= "Missing field: $field. ";
            break;
        }
    }
    
    if (!$error && $payment === 'kreditkarte' && !preg_match('/^\d{16}$/', $card)) {
        $error = 'Bitte eine gültige 16-stellige Kreditkartennummer eingeben.';
        $debug_info .= "Invalid card number. Length: " . strlen($card) . ". ";
    }
    
    if (!$error) {
        try {
            $debug_info .= "Attempting to save order. ";
            $orders = loadOrders();
            $orderId = count($orders) + 1;
            $debug_info .= "Order ID: $orderId. ";
            
            $orders[] = [
                'id' => $orderId,
                'customer' => [
                    'name' => trim($_POST['name']),
                    'email' => trim($_POST['email']),
                    'street' => trim($_POST['street']),
                    'house_number' => trim($_POST['house_number']),
                    'zip' => trim($_POST['zip']),
                    'city' => trim($_POST['city'])
                ],
                'payment' => [
                    'type' => $payment, 
                    'card_number' => $payment === 'kreditkarte' ? $card : null
                ],
                'items' => $cart,
                'status' => 'In Bearbeitung',
                'date' => date('Y-m-d H:i:s')
            ];
            
            saveOrders($orders);
            $debug_info .= "Order saved successfully. ";
            $_SESSION['cart'] = [];
            header('Location: order-confirmation.php?id='.$orderId);
            exit;
        } catch (Exception $e) {
            $error = $e->getMessage();
            $debug_info .= "Exception: " . $e->getMessage() . ". ";
        }
    }
}
$title = 'Kasse';
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
<h1>Kasse</h1>

<?php if ($debug_info && isset($_GET['debug'])): ?>
    <div style="background: #e7f3ff; padding: 10px; border: 1px solid #b3d9ff; margin-bottom: 15px;">
        <strong>Debug Info:</strong> <?= htmlspecialchars($debug_info) ?>
    </div>
<?php endif; ?>

<form method="post" data-autosave="true">
  <?php if ($error): ?>
    <div class="error"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>
  
  <label>Name
    <input type="text" name="name" required value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
  </label>
  <label>Email
    <input type="email" name="email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
  </label>
  <label>Straße
    <input type="text" name="street" required value="<?= htmlspecialchars($_POST['street'] ?? '') ?>">
  </label>
  <label>Hausnummer
    <input type="text" name="house_number" required value="<?= htmlspecialchars($_POST['house_number'] ?? '') ?>">
  </label>
  <label>PLZ
    <input type="text" name="zip" required value="<?= htmlspecialchars($_POST['zip'] ?? '') ?>">
  </label>
  <label>Stadt
    <input type="text" name="city" required value="<?= htmlspecialchars($_POST['city'] ?? '') ?>">
  </label>
  <label>Zahlungsart
    <select name="payment" id="payment-select">
      <option value="per-post" <?= ($_POST['payment'] ?? 'per-post') === 'per-post' ? 'selected' : '' ?>>Per Post</option>
      <option value="kreditkarte" <?= ($_POST['payment'] ?? '') === 'kreditkarte' ? 'selected' : '' ?>>Kreditkarte</option>
    </select>
  </label>
  <div id="credit-card" style="display:none;">
    <label>Kreditkartennummer (16 Stellen)
      <input type="text" name="card_number" id="card_number" 
             placeholder="____ ____ ____ ____" 
             maxlength="19" 
             pattern="[0-9\s]{13,19}"
             value="<?= htmlspecialchars($_POST['card_number'] ?? '') ?>">
      <small>Format: 1234 5678 9012 3456</small>
    </label>
  </div>
  <p><a class="button" href="cart.php">Zurück zum Warenkorb</a></p>
  <button type="submit">Bestellung abschicken</button>
</form>
</div>
<?php include __DIR__.'/../footer.php'; ?>
<script src="/js/main.js"></script>
</body>
</html>
