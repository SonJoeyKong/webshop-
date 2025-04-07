<?php
session_start();
$cart = $_SESSION['cart'] ?? [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Afrekenen</title>

    <link rel="stylesheet" href="../../css/winkelwagen.css">
    <link rel="stylesheet" href="../../css/navbar.css">

    <!-- Chatbot Style - React Build -->
    <link rel="stylesheet" href="../chatbot/static/css/main.0e710cc4.css">
    
    <!-- icons van het menu & voor dat input field -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- alpine.js voor het hamburger menutje -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body>
    <h1>Afrekenen</h1>
    <div class="afreken-form">
        <form action="verwerk_betaling.php" method="POST">
        <label>Naam: <input type="text" name="naam" required></label><br>
        <label>Adres: <input type="text" name="adres" required></label><br>
        <button type="submit">Bestelling plaatsen</button>
    </form>
    </div>
    

    <div id="react-chatbot"></div>

    <!-- Chatbot Code -> React Build -->
    <script src="../chatbot/static/js/main.0eb252d4.js"></script>
</body>
</html>
