<?php
session_start();
$name = $_SESSION['name'] ?? 'Guest';
$dob = $_SESSION['dob'] ?? '';
$currency = $_POST['currency'] ?? $_SESSION['currency'] ?? 'INR';
$_SESSION['currency'] = $currency;

$rates = ['INR' => 1, 'USD' => 0.012, 'EUR' => 0.011];
$symbols = ['INR' => '₹', 'USD' => '$', 'EUR' => '€'];
$rate = $rates[$currency];
$symbol = $symbols[$currency];

$items = $_POST['items'] ?? [];
$coupon = strtolower(trim($_POST['coupon'] ?? ''));
$total = 0;
$loyaltyPoints = 0;
$billDetails = "";

$menu = [
    'Biriyani' => 120,
    'Full Meals' => 100,
    'Mini Meal' => 80,
    'Parotta' => 15,
    'Soda' => 15,
    'Ice Cream' => 50,
    'Chicken Fry' => 200,
    'Fish Fry' => 150,
    'Paneer Butter Masala' => 120,
    'Paneer Tikka' => 100
];

$discount = 0;
if ($coupon === 'gow28') {
    $discount = 0.99;
} elseif (in_array($coupon, ['spice20', 'hot20', 'cool20', 'yummy20', 'fresh20', 'south20', 'spicy20', 'tasty20', 'delight20', 'masala20'])) {
    $discount = 0.20;
}

foreach ($items as $item => $qty) {
    $qty = intval($qty);
    if ($qty > 0 && isset($menu[$item])) {
        $price = $menu[$item] * $qty;
        $total += $price;
        $billDetails .= "<tr><td>$item</td><td>$qty</td><td>{$symbol}" . number_format($menu[$item] * $rate, 2) . "</td><td>{$symbol}" . number_format($price * $rate, 2) . "</td></tr>";
    }
}

$loyaltyPoints = floor($total / 100) * 10;
$discountAmount = $total * $discount;
$finalTotal = $total - $discountAmount;
$convertedFinal = $finalTotal * $rate;
$qrText = urlencode("$name | Total: {$symbol}" . number_format($convertedFinal, 2));
?>
<!DOCTYPE html>
<html>
<head>
    <title>South Spice - Bill</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #ffe0b2, #fff8e1);
            text-align: center;
            margin: 0;
            padding: 0;
            animation: fadeIn 1s ease-in;
        }
        .receipt {
            background: #ffffff;
            margin: 40px auto;
            padding: 30px;
            width: 90%;
            max-width: 700px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
            animation: slideUp 1s ease-in-out;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        table th, table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .total {
            font-size: 22px;
            margin: 20px 0;
            color: #e65100;
        }
        .qr {
            margin: 20px auto;
        }
        .order-again {
            margin-top: 20px;
        }
        .order-again a {
            background: #ff9800;
            color: white;
            padding: 12px 25px;
            border-radius: 8px;
            text-decoration: none;
            transition: background 0.3s ease;
        }
        .order-again a:hover {
            background: #e65100;
        }
        .success-icon {
            font-size: 60px;
            color: green;
            margin-bottom: 10px;
            animation: pop 0.5s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(60px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes pop {
            0% { transform: scale(0); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="success-icon">✅</div>
        <h2>Thank you, <?php echo htmlspecialchars($name); ?>!</h2>
        <h3>Your Order Receipt</h3>
        <table>
            <tr><th>Item</th><th>Qty</th><th>Price</th><th>Total</th></tr>
            <?php echo $billDetails; ?>
        </table>
        <?php if ($discount > 0): ?>
            <p><strong>Coupon Applied:</strong> <?php echo strtoupper($coupon); ?> (<?php echo $discount * 100; ?>% OFF)</p>
        <?php endif; ?>
        <div class="total">Final Total: <?php echo $symbol . number_format($convertedFinal, 2); ?></div>
        <p>Loyalty Points Earned: <?php echo $loyaltyPoints; ?></p>
        <div class="qr">
            <img src="https://api.qrserver.com/v1/create-qr-code/?data=<?php echo $qrText; ?>&size=150x150" alt="QR Code">
        </div>
        <div class="order-again">
            <a href="menu.php">Order Again</a>
        </div>
    </div>
</body>
</html>
