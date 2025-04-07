<!-- 
 taal php 
 index.php door joey gemaakt 
 het doel van index.php is de landing page van de website.
 --->
<?php
session_start(); // Start de sessie
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ApotheCare</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/menu.css">
    
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
                    <img src="../images/logo.png" alt="ApotheCare Logo" class="logo">
                </a>
                
                <!-- Dit is een verzameling van alle belangrijken linken naar nieuwe websites binnen de navigatie bar.(Rechts) -->
                <a href="">ApotheCare</a>
                <a href="#">Producten</a>
                <a href="#">Chatbot</a> <!-- Chatbox words waarschijnlijk nog verplaats. -->
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
</body>
<!-- Hero Section -->
<section class="hero">
    <img src="../images/headimg.png" alt="Happy People" class="hero-img">
    <div class="hero-text">
        <h2>Apothecare</h2>
        <p>Wij brengen zorg bij u thuis</p>
        <p class="description">
            We helpen u graag om het leven met een zieke of chronische aandoening gemakkelijker te maken. Mediq levert incontinentiezorg, katheters, wondzorg, medische voeding en stomazorg, zodat u zich minder patiënt voelt en meer mens.
        </p>
        <div class="hero-buttons">
            <button class="btn">Over Ons</button>
            <button class="btn btn-secondary">Klanten Service</button>
        </div>
    </div>
</section>

<!-- Product Cards -->
<section class="products">
    <div class="product-card">
        <img src="../images/siroop.png" alt="Siroop">
        <h4>Siroop</h4>
        <p>Verzacht hoest en keelpijn</p>
        <span>€4,-</span>
    </div>
    <!-- product wiet -->
    <div class="product-card">
        <img src="../images/wiet.png" alt="Wiet">
        <h4>Wiet</h4>
        <p>Als je rust nodig hebt</p>
        <span>€5,-</span>
    </div>
    <!-- product paracetamol koorts -->
    <div class="product-card">
        <img src="../images/panadol.png" alt="Panadol">
        <h4>Panadol Kinderen</h4>
        <p>Verzacht koorts en pijn</p>
        <span>€6,-</span>
    </div>
    <!-- prodict paracetamol -->
    <div class="product-card">
        <img src="../images/paracetamol.png" alt="Paracetamol">
        <h4>Paracetamol</h4>
        <p>Pijnstillend en koortsverlagend</p>
        <span>€4,-</span>
    </div>
</section>

<!-- Footer Grid -->
<footer class="footer-grid">
    <?php for ($i = 0; $i < 4; $i++): ?>
        <ul>
            <?php for ($j = 0; $j < 6; $j++): ?>
                <li>> put text</li>
            <?php endfor; ?>
        </ul>
    <?php endfor; ?>
</footer>

</html>
