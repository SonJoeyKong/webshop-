<?php
require_once '../database.php';
session_start();

if (!isset($_GET['id'])) {
    header("Location: voorraad.php");
    exit();
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM product WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    header("Location: voorraad.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $naam = $_POST['naam'];
    $beschrijving = $_POST['beschrijving'];
    $prijs = $_POST['prijs'];
    $voorraad = $_POST['voorraad'];
    
    $stmt = $conn->prepare("UPDATE product SET product_naam = ?, product_beschrijving = ?, product_prijs = ?, product_voorraad = ? WHERE id = ?");
    $stmt->execute([$naam, $beschrijving, $prijs, $voorraad, $id]);
    
    header("Location: ../personeel/voorraad.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Bewerken</title>
    <link rel="stylesheet" href="../../css/test.css">
</head>
<body>
    <nav>
        <!-- Navigatiebalk code -->
    </nav>

    <div class="form-container">        <h1>Product Bewerken</h1>

        <form method="POST">
            <div class="form-group">
                <label for="naam">Productnaam:</label>
                <input type="text" id="naam" name="naam" value="<?= htmlspecialchars($product['product_naam']) ?>" required>
            </div>
            <div class="form-group">
                <label for="beschrijving">Beschrijving:</label>
                <textarea id="beschrijving" name="beschrijving" required><?= htmlspecialchars($product['product_beschrijving']) ?></textarea>
            </div>
            <div class="form-group">
                <label for="prijs">Prijs (€):</label>
                <input type="number" id="prijs" name="prijs" step="0.01" min="0" value="<?= $product['product_prijs'] ?>" required>
            </div>
            <div class="form-group">
                <label for="voorraad">Voorraad:</label>
                <input type="number" id="voorraad" name="voorraad" min="0" value="<?= $product['product_voorraad'] ?>" required>
            </div>
            <div class="form-actions">
                <a href="../personeel/voorraad.php" class="cancel-btn">Annuleren</a>
                <button type="submit" class="submit-btn">Wijzigingen Opslaan</button>
            </div>
        </form>
    </div>
</body>
</html>