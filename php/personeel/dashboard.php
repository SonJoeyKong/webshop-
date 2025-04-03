<?php
require_once '../database.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
    <div class="openbestellingen">
        <img src="../../images/icons/orders_icon.png">
        <?php 
        $query = "SELECT COUNT(*) AS aantal_open_bestellingen FROM bestelling WHERE status_bestelling = 'open'";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        echo "<p>" . ($result['aantal_open_bestellingen'] ?? 0) . "</p>";
        ?>
        <span>Openstaande Bestellingen</span>
    </div>

    <div class="omzet">
        <img src="../../images/icons/omzet_icon.png">
        <?php 
        $query = "SELECT SUM(totaal_prijs) AS omzet FROM bestelling WHERE status_bestelling = 'verwerkt'";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        echo "<p>€" . number_format(($result['omzet'] ?? 0), 2, ',', '.') . "</p>";
        ?>
        <span>Totale Omzet</span>
    </div>

    <div class="totaleproducten">
        <img src="../../images/icons/producten_icon.png">
        <?php 
        $query = "SELECT COUNT(*) AS aantal_producten FROM product"; 
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        echo "<p>" . ($result['aantal_producten'] ?? 0) . "</p>";
        ?>
        <span>Totaal Producten</span>
    </div>

    <div class="totaleklanten">
        <img src="../../images/icons/klanten_icon.png">
        <?php
        $query = "SELECT COUNT(*) AS aantal_klanten FROM gebruiker";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        echo "<p>" . ($result['aantal_klanten'] ?? 0) . "</p>";
        ?>
        <span>Totale Klanten</span>
    </div>
</body>
</html>
