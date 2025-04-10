<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['name'] = $_POST['name'] ?: 'Guest';
    $_SESSION['dob'] = $_POST['dob'] ?? '';
    $file = fopen("E:/logins.txt", "a");
    fwrite($file, $_POST['name'] . "|" . $_POST['dob'] . "\n");
    fclose($file);
    header("Location: menu.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>South Spice | Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa&family=Poppins:wght@500&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
            animation: fadeIn 1s ease-in-out;
        }

        .container {
            width: 100%;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .login-box {
            background: rgba(255, 255, 255, 0.95);
            padding: 50px;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            text-align: center;
            max-width: 400px;
            width: 90%;
            animation: slideIn 1s ease forwards;
        }

        h1 {
            color: #ff6f00;
            margin-bottom: 20px;
            font-size: 2.5em;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.1);
        }

        input[type="text"], input[type="date"] {
            width: 90%;
            padding: 12px 15px;
            margin: 10px 0;
            border: 2px solid #ff9800;
            border-radius: 10px;
            outline: none;
            font-size: 16px;
            transition: 0.3s ease;
        }

        input[type="text"]:focus, input[type="date"]:focus {
            border-color: #e65100;
            box-shadow: 0 0 8px #ff9800;
        }

        button {
            margin-top: 20px;
            background: linear-gradient(to right, #ff6f00, #ff9800);
            border: none;
            color: white;
            padding: 12px 30px;
            font-size: 16px;
            border-radius: 12px;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        button:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 18px rgba(0,0,0,0.2);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideIn {
            0% { transform: translateY(40px); opacity: 0; }
            100% { transform: translateY(0); opacity: 1; }
        }

        .footer-note {
            margin-top: 20px;
            font-size: 14px;
            color: #888;
        }

        .bubble {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            animation: floatUp 10s infinite ease-in-out;
        }

        .bubble:nth-child(1) { width: 60px; height: 60px; left: 10%; animation-delay: 0s; }
        .bubble:nth-child(2) { width: 80px; height: 80px; left: 30%; animation-delay: 3s; }
        .bubble:nth-child(3) { width: 40px; height: 40px; left: 70%; animation-delay: 6s; }
        .bubble:nth-child(4) { width: 100px; height: 100px; left: 50%; animation-delay: 1s; }

        @keyframes floatUp {
            0% { bottom: -100px; opacity: 0; }
            50% { opacity: 0.5; }
            100% { bottom: 110%; opacity: 0; }
        }
    </style>
</head>
<body>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="container">
        <div class="login-box">
            <h1>Welcome to South Spice</h1>
            <form method="post">
                <input type="text" name="name" placeholder="Enter Your Name" required><br>
                <input type="date" name="dob" required><br>
                <button type="submit">Order Now</button>
            </form>
        </div>
    </div>
</body>
</html>
