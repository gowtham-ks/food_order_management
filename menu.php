<?php
session_start();
$name = $_SESSION['name'] ?? 'Guest';
$dob = $_SESSION['dob'] ?? '';
$currency = $_POST['currency'] ?? ($_SESSION['currency'] ?? 'INR');
$_SESSION['currency'] = $currency;

$rates = ['INR' => 1, 'USD' => 0.012, 'EUR' => 0.011];
$symbols = ['INR' => '₹', 'USD' => '$', 'EUR' => '€'];
$rate = $rates[$currency];
$symbol = $symbols[$currency];

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
?>
<!DOCTYPE html>
<html>
<head>
    <title>South Spice Menu</title>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Quicksand', sans-serif;
            background: linear-gradient(to right, #ffe0b2, #ffcc80);
            margin: 0;
            padding: 0;
            animation: fadeIn 1s ease-in-out;
        }
        .container {
            width: 90%;
            max-width: 1000px;
            margin: 0 auto;
            padding: 40px 0;
        }
        h1 {
            text-align: center;
            color: #e65100;
            margin-bottom: 30px;
        }
        form {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            width: 220px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            text-align: center;
        }
        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.3);
        }
        .card img {
            width: 100%;
            border-radius: 10px;
        }
        .card h3 {
            margin: 10px 0;
            color: #e65100;
        }
        .card p {
            margin: 5px 0;
        }
        .card input[type="number"] {
            width: 60px;
            padding: 5px;
            margin-top: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
        }
        .footer input[type="text"], select {
            padding: 10px;
            font-size: 16px;
            margin: 10px;
            border-radius: 8px;
            border: 1px solid #aaa;
        }
        .footer button {
            background: #ff9800;
            color: white;
            border: none;
            padding: 12px 25px;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .footer button:hover {
            background: #e65100;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome, <?php echo htmlspecialchars($name); ?>! Explore Our Menu</h1>

        <form method="post">
            <div class="footer">
                <label for="currency">Currency:</label>
                <select name="currency" onchange="this.form.submit()">
                    <option value="INR" <?php if ($currency=='INR') echo 'selected'; ?>>INR (₹)</option>
                    <option value="USD" <?php if ($currency=='USD') echo 'selected'; ?>>USD ($)</option>
                    <option value="EUR" <?php if ($currency=='EUR') echo 'selected'; ?>>EUR (€)</option>
                </select>
            </div>
        </form>

        <form action="bill.php" method="post">
            <?php foreach ($menu as $item => $price): ?>
            <div class="card">
                <img src="images/<?php echo urlencode(strtolower(str_replace(' ', '_', $item))); ?>.jpg" alt="<?php echo $item; ?>">
                <h3><?php echo $item; ?></h3>
                <p>Price: <?php echo $symbol . number_format($price * $rate, 2); ?></p>
                <input type="number" name="items[<?php echo $item; ?>]" min="0" placeholder="Qty">
            </div>
            <?php endforeach; ?>
            <div class="footer">
                <label for="coupon">Coupon Code:</label>
                <input type="text" name="coupon" placeholder="Enter Coupon ">
                <br>
                <button type="submit">Place Order</button>
            </div>
        </form>
    </div>
</body>
</html>
