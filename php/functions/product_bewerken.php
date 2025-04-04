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
    <title>Product Toevoegen - Apothecare</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <style>
        /* Voeg de CSS toe die ik eerder heb gegeven */
    </style>
</head>
<body>
    <!-- Navigatiebalk hier -->

    <div class="form-container">
        <h1 class="form-title">Product Toevoegen</h1>
        
        <form method="POST">
            <div class="form-group">
                <label for="naam">Productnaam</label>
                <input type="text" id="naam" name="naam" class="form-input" required>
            </div>
            
            <div class="form-group">
                <label for="beschrijving">Beschrijving</label>
                <textarea id="beschrijving" name="beschrijving" class="form-input" required></textarea>
            </div>
            
            <div class="form-group">
                <label for="prijs">Prijs (€)</label>
                <input type="number" id="prijs" name="prijs" step="0.01" min="0" class="form-input" required>
            </div>
            
            <div class="form-group">
                <label for="voorraad">Voorraad</label>
                <input type="number" id="voorraad" name="voorraad" min="0" class="form-input" required>
            </div>
            
            <div class="form-actions">
                <a href="../personeel/voorraad.php" class="btn btn-cancel">Annuleren</a>
                <button type="submit" name="submit" class="btn btn-submit">Product Toevoegen</button>
            </div>
        </form>
    </div>
</body>
</html>