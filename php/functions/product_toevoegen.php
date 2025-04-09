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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Toevoegen - Apothecare</title>
    <link rel="stylesheet" href="../../css/test.css">
    <link rel="stylesheet" href="../../css/navbar.css"> <!-- CSS voor de navbar -->
    
    <!-- icons van het menu & voor dat input field -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- alpine.js voor het hamburger menutje -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body>
    <nav> 
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
