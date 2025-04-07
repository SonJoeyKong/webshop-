<?php
require_once '../database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $naam = $_POST['naam'];
    $beschrijving = $_POST['beschrijving'];
    $prijs = $_POST['prijs'];
    $voorraad = $_POST['voorraad'];

    // Upload map (relatief pad vanaf deze file)
    $upload_dir = '../../images/products/';

    // Bestandsinformatie ophalen
    $afbeelding = $_FILES['afbeelding'];

    // Genereer unieke naam om conflicts te voorkomen
    $ext = pathinfo($afbeelding['name'], PATHINFO_EXTENSION);
    $unique_name = uniqid('product_') . '.' . $ext;
    $upload_path = $upload_dir . $unique_name;

    // Beweeg het bestand naar de upload folder
    if (move_uploaded_file($afbeelding['tmp_name'], $upload_path)) {
        // Sla de gegevens inclusief afbeelding op in de DB
        $stmt = $conn->prepare("INSERT INTO product (product_naam, product_beschrijving, product_prijs, product_voorraad, product_afbeelding) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$naam, $beschrijving, $prijs, $voorraad, $unique_name]);

        header("Location: ../personeel/voorraad.php");
        exit();
    } else {
        echo "Fout bij het uploaden van de afbeelding.";
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Toevoegen - Apothecare</title>
    <link rel="stylesheet" href="../../css/test.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Navigatiebalk hier (zelfde als andere pagina's) -->

    <div class="form-container">
        <h1 class="form-title">Product Toevoegen</h1>
        
        <form method="POST" action="product_toevoegen.php" enctype="multipart/form-data">
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

            <div class="form-group">
                <label for="afbeelding">Afbeelding</label>
                <input type="file" id="afbeelding" name="afbeelding" accept="image/*" class="form-input" required>
            </div>
            
            <div class="form-actions">
                <a href="../personeel/voorraad.php" class="btn btn-cancel">Annuleren</a>
                <button type="submit" class="btn btn-submit">Product Toevoegen</button>
            </div>
        </form>
    </div>
</body>
</html>
