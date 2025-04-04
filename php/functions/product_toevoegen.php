<?php
require_once '../database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $naam = $_POST['naam'];
    $beschrijving = $_POST['beschrijving'];
    $prijs = $_POST['prijs'];
    $voorraad = $_POST['voorraad'];
    
    $stmt = $conn->prepare("INSERT INTO product (product_naam, product_beschrijving, product_prijs, product_voorraad) VALUES (?, ?, ?, ?)");
    $stmt->execute([$naam, $beschrijving, $prijs, $voorraad]);
    
    header("Location: ../personeel/voorraad.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Toevoegen</title>
    <link rel="stylesheet" href="../../css/test.css">
</head>
<body>
    <nav>
        <!-- Navigatiebalk code -->
    </nav>

    <div class="form-container">
        <h1>Product Toevoegen</h1>
        <form method="POST">
            <div class="form-group">
                <label for="naam">Productnaam:</label>
                <input type="text" id="naam" name="naam" required>
            </div>
            <div class="form-group">
                <label for="beschrijving">Beschrijving:</label>
                <textarea id="beschrijving" name="beschrijving" required></textarea>
            </div>
            <div class="form-group">
                <label for="prijs">Prijs (€):</label>
                <input type="number" id="prijs" name="prijs" step="0.01" min="0" required>
            </div>
            <div class="form-group">
                <label for="voorraad">Voorraad:</label>
                <input type="number" id="voorraad" name="voorraad" min="0" required>
            </div>
            <div class="form-actions">
                <a href="voorraad.php" class="cancel-btn">Annuleren</a>
                <button type="submit" class="submit-btn">Product Toevoegen</button>
            </div>
        </form>
    </div>
</body>
</html>