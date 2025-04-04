<?php
require_once "../database.php";

//session starten
session_start();

// redirecten als je niet logged in bent
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// producten ophalen uit db
$stmt = $conn->prepare("SELECT * FROM product");
$stmt->execute();
$product = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/menu.css">
    <script src="../../javascript/cart.js"></script>

    <!-- icons van het menu & voor dat input field -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- alpine.js voor het hamburger menutje -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body>
    <?php
    foreach ($product as $producten) // voor elk product een array maken
    {
        echo "<div class='product'>";
        echo "<h2>" . $producten['product_naam'] . "</h2>";
        echo "<p>Prijs: " . $producten['product_prijs'] . "</p>";
        echo "<p>Beschrijving: " . $producten['product_beschrijving'] . "</p>";
        echo "<div class='product-buttons'>";
        echo "<button onclick='decreaseQuantity(\"" . $producten['product_naam'] . "\")' data-product-id='" . $producten['product_naam'] . "'>-</button>";
        echo "<span id='quantity-" . $producten['product_naam'] . "' data-product-id='" . $producten['product_naam'] . "'>0</span>";
        echo "<button onclick='increaseQuantity(\"" . $producten['product_naam'] . "\")' data-product-id='" . $producten['product_naam'] . "'>+</button>";
        echo "</div>";
        echo "</div>";
    }
    ?>
</body>
</html>