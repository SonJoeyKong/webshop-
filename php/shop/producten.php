<?php
require_once "../database.php";

//session starten
session_start();

// redirecten als je niet logged in bent
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// producten ophalen uit db
$stmt = $conn->prepare("SELECT * FROM product");
$stmt->execute();
$product = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<nav> <!--Dit is de standaard navigatie bar die we globaal gebruiken. vergeet niet de namen en Href te veranderen voor correcte page.  -->
        <div class="nav-container"> 
            <div class="nav-left">
                <a href="" class="logo-link">
                    <img src="../images/logo.png" alt="ApotheCare Logo" class="logo">
                </a>
                <a href="">Apothecare</a>
                <a href="producten.php">Producten</a>
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
                        <img src="../images/icons/cart_icon.png" alt="Winkelwagen Icoon" width="50px">
                    </a>

                    <!-- Dropdown menu -->
                    <div class="menu" x-data="{ open: false }">
                        <button @click="open = !open" class="menu-button">
                            <img src="../images/icons/menu_icon.png" alt="Menu Icoon" width="50px">
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

    <?php
    foreach ($product as $producten) // voor elk product een array maken
    {
        echo "<div class='product'>";
        echo "<h2>" . $producten['product_naam'] . "</h2>";
        echo "<p>Prijs: " . $producten['product_prijs'] . "</p>";
        echo "<p>Beschrijving: " . $producten['product_beschrijving'] . "</p>";
        echo "</div>";
    }
    ?>
</body>
</html>