<!-- 
 taal css en html
onver-ons door: Kieran
 het doel van onver-ons.php is informatie geven over apothecare.
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
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/navbar.css"> <!-- Dit werkt niet style veranderd namelijk niet ! -->
    
    <!-- icons van het menu & voor dat input field -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- alpine.js voor het hamburger menutje -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body>
<!-- Hier begint de navigatie_balk.   -->
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


<section class="bigtext">
    <h1>Klanten service</h1>
    <p>heeft u vragen of een probleem?</p>
    <li><strong>contact :</strong> apothecare@outlook.nl </li>
    <li><strong>telefoonnummer :</strong> 06-12345678</li>
    <li><strong>adres :</strong> apothecare 1234 AB</li>
    <p>Onze klantenservice staat voor u klaar om u te helpen met al uw vragen en problemen. <br>
        Wij streven ernaar om u zo snel mogelijk van dienst te zijn.</p>
    
    <li><strong>Openingstijden klantenservice :</strong> Maandag t/m Vrijdag van 09:00 tot 17:00</li>
    <li><strong>Reactietijd e-mail :</strong> Binnen 24 uur op werkdagen</li>
    Live chat beschikbaar via onze website tijdens openingstijden
    
    <p>Wij waarderen uw feedback en suggesties. Neem gerust contact met ons op!</p>
</section>
<footer style="position: fixed; bottom: 0; width: 100%; text-align: center; background-color: #f1f1f1; padding: 0px; box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);">
    <p class="copyright">© 2025. Alle rechten voorbehouden.
    Neem contact op via mborijnland@hotmail.nl</p>
</footer>

<div id="react-chatbot" style="position: fixed; bottom: 20px; right: 20px; z-index: 1000; padding:0; ,margin:0;"></div>

<!-- Chatbot Code -> React Build -->
<script src="chatbot/static/js/main.0eb252d4.js"></script>
</body>
</html> 