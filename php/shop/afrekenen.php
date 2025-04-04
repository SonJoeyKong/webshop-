<?php
session_start();
$cart = $_SESSION['cart'] ?? [];
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Afrekenen</title>
</head>
<body>
    <h1>Afrekenen</h1>
    <form action="verwerk_betaling.php" method="POST">
        <label>Naam: <input type="text" name="naam" required></label><br>
        <label>Adres: <input type="text" name="adres" required></label><br>
        <button type="submit">Bestelling plaatsen</button>
    </form>
</body>
</html>
