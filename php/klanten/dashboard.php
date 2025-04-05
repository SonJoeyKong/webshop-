<?php
session_start(); 
require_once '../database.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ApotheCare</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/menu.css">
    
    <!-- icons van het menu & voor dat input field -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- alpine.js voor het hamburger menutje -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body>
    <nav> 
        <div class="nav-container"> 
            <div class="nav-left">
                <a href="../index.html" class="logo-link">
                    <img src="../../images/logo.png" alt="ApotheCare Logo" class="logo">
                    <span>Apothecare</span>
                </a>
                <a href="#">Producten</a>
                <a href="#">Chatbot</a>
            </div>
            <div class="search-container"> 
                <div class="search-group">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input placeholder="Zoek een product...">
                    <button>Meer zorg</button>
                </div>
            </div>
            <div class="nav-right">
                <?php if (isset($_SESSION['username'])): ?> <!-- dit zie je alleen als je een session heb -->
                    <!-- Winkelwagen knop -->
                    <a href="cart.php">
                        <img src="../../images/icons/cart_icon.png" alt="Winkelwagen Icoon" width="50px">
                    </a>

                    <!-- Dropdown menu -->
                    <div class="menu" x-data="{ open: false }">
                        <button @click="open = !open" class="menu-button">
                            <img src="../../images/icons/menu_icon.png" alt="Menu Icoon" width="50px">
                        </button>

                        <!-- Menu-items -->
                        <div class="menu-dropdown" x-show="open" x-transition @click.away="open = false">
                            <a href="dashboard.php"><i class="fa-solid fa-user"></i> Dashboard</a>
                            <a href="cart.php"><i class="fa-solid fa-shopping-cart"></i> Winkelwagen</a>
                            <a href="signout.php"><i class="fa-solid fa-sign-out-alt"></i> Uitloggen</a>
                        </div>
                    </div>
                <?php else: ?> <!-- anders zie je dit alleen -->
                    <a href="login.php">Inloggen</a>
                    <a href="register.php">Registreren</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <main>
        <div class="dashboard-container">
            <h1>Mijn Medicatie</h1>
            <?php
            $userid = $_SESSION['user_id'];

            $stmt = $conn->prepare("SELECT * FROM recepten WHERE gebruiker_id = :userid");
            $stmt->bindParam(':userid', $userid, PDO::PARAM_INT);
            $stmt->execute();
            $recepten = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($recepten as $recept) {
                // Haal productinformatie op
                $productStmt = $conn->prepare("SELECT * FROM product WHERE id = :product_id");
                $productStmt->bindParam(':product_id', $recept['product_id'], PDO::PARAM_INT);
                $productStmt->execute();
                $product = $productStmt->fetch(PDO::FETCH_ASSOC);

                echo "<div class='recept'>";
                echo "<h2>" . htmlspecialchars($product['product_naam']) . "</h2>";
                echo "<p>" . htmlspecialchars($product['product_beschrijving']) . "</p>";
                echo "<p>Prijs: €" . htmlspecialchars($product['product_prijs']) . "</p>";
                echo "</div>";
            }
            ?>
        </div>

        <div class="dashboard-container">
            <h1>Mijn Leveringen</h1>
            <?php
            $userid = $_SESSION['user_id'];

            $stmt = $conn->prepare("SELECT * FROM bestelling WHERE gebruiker_id = :userid");
            $stmt->bindParam(':userid', $userid, PDO::PARAM_INT);
            $stmt->execute();
            $bestellingen = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($bestellingen as $bestelling) {
                // Haal productinformatie op
                $productStmt = $conn->prepare("SELECT * FROM product WHERE id = :product_id");
                $productStmt->bindParam(':product_id', $bestelling['product_id'], PDO::PARAM_INT);
                $productStmt->execute();
                $product = $productStmt->fetch(PDO::FETCH_ASSOC);

                echo "<div class='bestelling'>";
                echo "<h2>" . htmlspecialchars($product['product_naam']) . "</h2>";
                echo "<p>" . htmlspecialchars($product['product_beschrijving']) . "</p>";
                echo "<p>Prijs: €" . htmlspecialchars($product['product_prijs']) . "</p>";
                echo "</div>";
            }
            ?>
        </div>

        <div class="dashboard-container-small">
            <h1>Afspraken</h1>
            <p>WIP</p>
        </div>

        <div class="dashboard-container-small">
            <h1>Notificaties</h1>
            <p>WIP</p>
        </div>
    </main>
</body>
</html>
