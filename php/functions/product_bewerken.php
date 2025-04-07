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
    <link rel="stylesheet" href="../../css/navbar.css"> <!-- CSS voor de navbar -->
    
    <!-- icons van het menu & voor dat input field -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- alpine.js voor het hamburger menutje -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body>
<div class="nav-container">
            <div class="nav-left">
                <a href="" class="logo-link">
                    <!-- Logo Link -->
                    <img src="../../images/logo.png" alt="ApotheCare Logo" class="logo">
                </a>
                
                <!-- Dit is een verzameling van alle belangrijken linken naar nieuwe websites binnen de navigatie bar.(Rechts) -->
                <a href="../index.php">ApotheCare</a>
                <a href="../shop/producten.php">Producten</a>
            </div>
            <div class="search-container"> 
                <div class="search-group">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input placeholder="Zoek een product...">
                    <button>Meer zorg</button> <!-- Dit moet een Uitklapbare tabworden -->
                </div>
            </div>
            <div class="nav-right">
                <?php if (isset($_SESSION['username'])): ?> <!-- dit zie je alleen als je een session heb -->
                    <!-- Winkelwagen knop -->
                    <a href="../shop/cart.php">
                        <img src="../../images/icons/cart_icon.png" alt="Winkelwagen Icoon" width="50px">
                    </a>

                    <!-- Dropdown menu -->
                    <div class="menu" x-data="{ open: false }">
                        <button @click="open = !open" class="menu-button">
                            <img src="../../images/icons/menu_icon.png" alt="Menu Icoon" width="50px">
                        </button>

                        <!-- Menu-items -->
                        <div class="menu-dropdown" x-show="open" x-transition @click.away="open = false">
                            <a href="../dashboard.php"><i class="fa-solid fa-user"></i> Dashboard</a>
                            <a href="../shop/cart.php"><i class="fa-solid fa-shopping-cart"></i> Winkelwagen</a>
                            <a href="../signout.php"><i class="fa-solid fa-sign-out-alt"></i> Uitloggen</a>
                        </div>
                    </div>
                <?php else: ?> <!-- anders zie je dit alleen -->
                    <a href="../login.php">Inloggen</a>
                    <a href="../register.php">Registreren</a>
                <?php endif; ?>
            </div>
        </div>
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