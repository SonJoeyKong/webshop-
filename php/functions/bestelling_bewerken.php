<?php
require_once '../database.php';
session_start();

if (!isset($_GET['id'])) {
    header("Location: voorraad.php");
    exit();
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM bestelling WHERE id = ?");
$stmt->execute([$id]);
$bestelling = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$bestelling) {
    header("Location: voorraad.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'];
    
    $stmt = $conn->prepare("UPDATE bestelling SET status_bestelling = ? WHERE id = ?");
    $stmt->execute([$status, $id]);
    
    header("Location: ../personeel/bestellingen.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bestelling Bewerken</title>
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
    <h1>Bestelling Bewerken - Nr. <?php echo ("$id")?></h1>

    <form method="POST">
        <div class="form-group">
            <label for="status">Status van bestelling:</label>
            <select id="status" name="status" required>
                <option value="open" <?= $bestelling['status_bestelling'] === 'open' ? 'selected' : '' ?>>Open</option>
                <option value="verwerkt" <?= $bestelling['status_bestelling'] === 'verwerkt' ? 'selected' : '' ?>>Verwerkt</option>
                <option value="voltooid" <?= $bestelling['status_bestelling'] === 'voltooid' ? 'selected' : '' ?>>Voltooid</option>
            </select>
        </div>
        <div class="form-actions">
            <a href="../personeel/voorraad.php" class="cancel-btn">Annuleren</a>
            <button type="submit" class="submit-btn">Wijzigingen Opslaan</button>
        </div>
    </form>
    </div>
</body>
</html>