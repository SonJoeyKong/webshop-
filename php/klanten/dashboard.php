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
    <link rel="stylesheet" href="../../css/navbar.css"> <!-- CSS voor de navbar -->
    <link rel="stylesheet" href="../../css/dev.css"> <!-- CSS voor de dashboard pagina -->
    
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

    <!-- MAIN met 4-op-een-rij containers -->
    <main class="dashboard-grid">

    <!-- Mijn Medicatie -->
    <div class="dashboard-box">
        <h2>Mijn Medicatie</h2>
        <hr>
        <?php
        $userid = $_SESSION['user_id'];
        $stmt = $conn->prepare("SELECT * FROM recepten WHERE gebruiker_id = :userid");
        $stmt->bindParam(':userid', $userid, PDO::PARAM_INT);
        $stmt->execute();
        $recepten = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($recepten) {
            foreach ($recepten as $recept) {
                $productStmt = $conn->prepare("SELECT * FROM product WHERE id = :product_id");
                $productStmt->bindParam(':product_id', $recept['product_id'], PDO::PARAM_INT);
                $productStmt->execute();
                $product = $productStmt->fetch(PDO::FETCH_ASSOC);

                echo "<p><strong>Naam:</strong> " . htmlspecialchars($product['product_naam']) . "<br>";
                echo "<strong>Dosering:</strong> WIP<br>";
                echo "<strong>Bijwerkingen:</strong> WIP<br><br>";
                echo "<strong>Laatste Vernieuwing:</strong> WIP<br>";
                echo "<strong>Automatische Herhaling:</strong> WIP</p><br>";
            }
        } else {
            echo "<p>WIP</p>";
        }
        ?>
    </div>

    <!-- Mijn Leveringen -->
    <div class="dashboard-box">
        <h2>Mijn Leveringen</h2>
        <hr>
        <?php
        $stmt = $conn->prepare("SELECT * FROM bestelling WHERE gebruiker_id = :userid");
        $stmt->bindParam(':userid', $userid, PDO::PARAM_INT);
        $stmt->execute();
        $bestellingen = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($bestellingen) {
            foreach ($bestellingen as $bestelling) {
                $productStmt = $conn->prepare("SELECT * FROM product WHERE id = :product_id");
                $productStmt->bindParam(':product_id', $bestelling['product_id'], PDO::PARAM_INT);
                $productStmt->execute();
                $product = $productStmt->fetch(PDO::FETCH_ASSOC);

                echo "<p><strong>Bestelnummer:</strong> " . strtoupper(substr(md5($bestelling['id']), 0, 7)) . "<br>";
                echo "<strong>Medicijn:</strong> " . htmlspecialchars($product['product_naam']) . "<br>";
                echo "<strong>Status:</strong> " . htmlspecialchars($bestelling['status_bestelling']) . "<br><br>";
                echo "<strong>Verwachte Leverdatum:</strong> " . date('d-m-Y', strtotime($bestelling['aflever_datum'])) . "<br>";
                echo "<strong>Afhaaloptie:</strong> " . htmlspecialchars($bestelling['gebruiker_adres']) . "</p><br>";
            }
        } else {
            echo "<p>WIP</p>";
        }
        ?>
    </div>

    <!-- Rechterzijde: Afspraken + Notificaties -->
    <div class="dashboard-right">
        <div class="dashboard-box">
            <h2>Afspraken</h2>
            <hr>
            <p>
                <strong>Datum:</strong> 25-04-2025<br>
                <strong>Tijd:</strong> 14:30<br>
                <strong>Type:</strong> Medicatie afhalen<br>
                <strong>Locatie:</strong> Online (Teams)
            </p>
        </div>

        <div class="dashboard-box">
            <h2>Notificaties</h2>
            <hr>
            <p>
                <strong>Type:</strong> Herinnering<br>
                <strong>Bericht:</strong> Tijd om paracetamol te nemen<br>
                <strong>Tijdstip:</strong> 04-01-2025 08:00
            </p>
        </div>
    </div>
</main>


<footer style="position: fixed; bottom: 0; width: 100%; text-align: center; background-color: #f1f1f1; padding: 0px; box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);">
    <p class="copyright">© 2025. Alle rechten voorbehouden.
    Neem contact op via mborijnland@hotmail.nl</p>
</footer>

<div id="react-chatbot" style="position: fixed; bottom: 20px; right: 20px; z-index: 1000; padding:0; ,margin:0;"></div>

<!-- Chatbot Code -> React Build -->
<script src="chatbot/static/js/main.0eb252d4.js"></script>
</body>

</html>
