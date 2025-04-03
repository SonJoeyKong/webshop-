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
</head>
<body>
    <?php
    foreach ($product as $producten) // voor elk product een array maken
    {
        echo "<div class='product'>";
        echo "<h2>" . $producten['product_naam'] . "</h2>";
        echo "<p>Prijs: " . $producten['product_prijs'] . "</p>";
        echo "<p>Beschrijving: " . $producten['product_beschrijving'] . "</p>";
        echo "</div>";
    }
    ?>
</body>
</html>