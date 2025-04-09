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
                <a href="" class="logo-link">
                    <!-- Logo Link -->
                    <img src="../../images/logo.png" alt="ApotheCare Logo" class="logo">
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
            </div>
        </div>
    </nav>


<div class="bigtext">
    <h1>over ons</h1>
<p id="overonsTOP">Bij ApotheCare staan we klaar om jou te helpen met alles wat te maken heeft met medicatie en gezondheid.</p> 
<p>Als nieuwe, moderne online apotheek maken we het eenvoudig om jouw geneesmiddelen te bestellen,</p>
<p>informatie op te zoeken over medicatie en bijsluiters, én herhaalrecepten aan te vragen.</p>
<p>Geen wachtrijen of gedoe meer - gewoon zorg, wanneer jij die nodig hebt.</p>
<br>
<p>Ons team van gediplomeerde apothekers en zorgexperts staat elke dag klaar om jou persoonlijk te ondersteunen.</p>
<p>We geloven dat ook online zorg menselijk, betrouwbaar en betrokken moet zijn.</p>
<p id="overonspBOT">Bij ApotheCare combineren we technologie met echte aandacht, zodat jij kunt rekenen op advies en service waarop je kunt vertrouwen.</p>
</div>
<div>
    <img src="../../images/headimg.png" alt="" id="overonsIMG">
</div>
</body>