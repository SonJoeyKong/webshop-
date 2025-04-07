<?php
require_once "../database.php";

//session starten
session_start();

// redirecten als je niet logged in bent
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
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
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/menu.css">
    <script src="../../javascript/cart.js"></script>

    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/navbar.css">
    <link rel="stylesheet" href="../../css/test.css">
    <!-- Chatbot Style - React Build -->
    <link rel="stylesheet" href="../chatbot/static/css/main.0e710cc4.css">
    
    <!-- icons van het menu & voor dat input field -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- alpine.js voor het hamburger menutje -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body>
<nav> 
        <div class="nav-container"> 
            <div class="nav-left">
<<<<<<< HEAD
                <a href="" class="logo-link">
                    <!-- Logo Link -->
                    <img src="../images/logo.png" alt="ApotheCare Logo" class="logo">
                </a>
                
                <!-- Dit is een verzameling van alle belangrijken linken naar nieuwe websites binnen de navigatie bar.(Rechts) -->
                <a href="">ApotheCare</a>
                <a href="">Producten</a>
                <a href="#">Chatbot</a> <!-- Chatbox words waarschijnlijk nog verplaats. -->
=======
                <a href="../index.php" class="logo-link">
                    <img src="../../images/logo.png" alt="ApotheCare Logo" class="logo">
                    <span>Apothecare</span>
                </a>
                <a href="producten.php">Producten</a>
                <a href="#">Chatbot</a>
>>>>>>> testing
            </div>
            <div class="search-container"> 
                <div class="search-group">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input placeholder="Zoek een product...">
<<<<<<< HEAD
                    <button>Meer zorg</button> <!-- Dit moet een Uitklapbare tabworden -->
=======
                    <button>Meer zorg</button>
>>>>>>> testing
                </div>
            </div>
            <div class="nav-right">
                <?php if (isset($_SESSION['username'])): ?> <!-- dit zie je alleen als je een session heb -->
                    <!-- Winkelwagen knop -->
<<<<<<< HEAD
                    <a href="cart.php">
                        <img src="../images/icons/cart_icon.png" alt="Winkelwagen Icoon" width="50px">
=======
                    <a href="shop/cart.php">
                        <img src="../../images/icons/cart_icon.png" alt="Winkelwagen Icoon" width="50px">
>>>>>>> testing
                    </a>

                    <!-- Dropdown menu -->
                    <div class="menu" x-data="{ open: false }">
                        <button @click="open = !open" class="menu-button">
<<<<<<< HEAD
                            <img src="../images/icons/menu_icon.png" alt="Menu Icoon" width="50px">
=======
                            <img src="../../images/icons/menu_icon.png" alt="Menu Icoon" width="50px">
>>>>>>> testing
                        </button>

                        <!-- Menu-items -->
                        <div class="menu-dropdown" x-show="open" x-transition @click.away="open = false">
<<<<<<< HEAD
                            <a href="dashboard.php"><i class="fa-solid fa-user"></i> Dashboard</a>
                            <a href="cart.php"><i class="fa-solid fa-shopping-cart"></i> Winkelwagen</a>
                            <a href="signout.php"><i class="fa-solid fa-sign-out-alt"></i> Uitloggen</a>
                        </div>
                    </div>
                <?php else: ?> <!-- anders zie je dit alleen -->
                    <a href="login.php">Inloggen</a>
                    <a href="register.php">Registreren</a>
=======
                            <a href="../dashboard.php"><i class="fa-solid fa-user"></i> Dashboard</a>
                            <a href="cart.php"><i class="fa-solid fa-shopping-cart"></i> Winkelwagen</a>
                            <a href="../signout.php"><i class="fa-solid fa-sign-out-alt"></i> Uitloggen</a>
                        </div>
                    </div>
                <?php else: ?> <!-- anders zie je dit alleen -->
                    <a href="../login.php">Inloggen</a>
                    <a href="../register.php">Registreren</a>
>>>>>>> testing
                <?php endif; ?>
            </div>
        </div>
    </nav>
<<<<<<< HEAD

=======
>>>>>>> testing
    <?php
    foreach ($product as $producten) // voor elk product een div maken
    {
        echo "<div class='product'>";
        echo "<h2>" . $producten['product_naam'] . "</h2>";
        echo "<p>Prijs: €" . number_format($producten['product_prijs'], 2, ',', '.') . "</p>";
        echo "<p>Beschrijving: " . $producten['product_beschrijving'] . "</p>";
        echo "<div class='product-buttons'>";
        
        echo "<button onclick='decreaseQuantity(\"" . $producten['product_naam'] . "\", " . $producten['product_prijs'] . ")' data-product-id='" . $producten['product_naam'] . "'>-</button>";
        echo "<span id='quantity-" . $producten['product_naam'] . "' data-product-id='" . $producten['product_naam'] . "'>0</span>";
        echo "<button onclick='increaseQuantity(\"" . $producten['product_naam'] . "\", " . $producten['product_prijs'] . ")' data-product-id='" . $producten['product_naam'] . "'>+</button>";
        
        echo "</div>";
        echo "</div>";
    }
    ?>

<div id="react-chatbot"></div>

<!-- Chatbot Code -> React Build -->
<script src="../chatbot/static/js/main.0eb252d4.js"></script>
</body>
</html>