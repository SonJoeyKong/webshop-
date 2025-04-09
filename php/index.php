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
    <link rel="stylesheet" href="../css/test.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <!-- Chatbot Style - React Build -->
    <link rel="stylesheet" href="chatbot/static/css/main.0e710cc4.css">
    
    <!-- icons van het menu & voor dat input field -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- alpine.js voor het hamburger menutje -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body>
    <!--- hier begint de navigatie balk.  -->
    <nav> 
        <div class="nav-container"> 
            <div class="nav-left">
                <a href="" class="logo-link">
                    <!-- Logo Link -->
                    <img src="../images/logo.png" alt="ApotheCare Logo" class="logo">
                </a>
                
                <!-- Dit is een verzameling van alle belangrijken linken naar nieuwe websites binnen de navigatie bar.(Rechts) -->
                <a href="index.php">ApotheCare</a>
                <a href="shop/producten.php">Producten</a>
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
                    <a href="shop/cart.php">
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
                            <a href="shop/cart.php"><i class="fa-solid fa-shopping-cart"></i> Winkelwagen</a>
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
        <a href="klanten/over-ons.php"><button  class="btn">Over Ons</button></a>
        <a href="klanten/contact.php"><button  class="btn btn-secondary">Klanten Service</button></a>
        </div>
    </div>
</section>
<div class="product-grid">
<?php
require_once "database.php";

$stmt = $conn->prepare("SELECT * FROM product LIMIT 5");
$stmt->execute();
$product = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($product) > 0) {
    foreach ($product as $producten) {
        echo "<div class='product-card'>";
        echo "<img src='../images/products/" . $producten['product_afbeelding'] . "' alt='" . $producten['product_naam'] . "' class='product-image'>";
        echo "<h2 class='product-title'>" . $producten['product_naam'] . "</h2>";
        echo "<p class='product-price'>€" . $producten['product_prijs'] . "</p>";
        echo "<p class='product-description'>" . $producten['product_beschrijving'] . "</p>";
        echo "</div>";
    }
} else {
    echo "<p>Geen producten gevonden.</p>";
}
?>
</div>

<!-- Product Cards
<section class="products">
    <div class="product-card">
        <img src="../images/siroop.png" alt="Siroop">
        <h4>Siroop</h4>
        <p>Verzacht hoest en keelpijn</p>
        <span>€4,-</span>
    </div>
    <div class="product-card">
        <img src="../images/wiet.png" alt="Wiet">
        <h4>Wiet</h4>
        <p>Als je rust nodig hebt</p>
        <span>€5,-</span>
    </div>
    <div class="product-card">
        <img src="../images/panadol.png" alt="Panadol">
        <h4>Panadol Kinderen</h4>
        <p>Verzacht koorts en pijn</p>
        <span>€6,-</span>
    </div>
    <div class="product-card">
        <img src="../images/paracetamol.png" alt="Paracetamol">
        <h4>Paracetamol</h4>
        <p>Pijnstillend en koortsverlagend</p>
        <span>€4,-</span>
    </div>
</section> -->

<!-- Footer Grid -->
<footer class="footer-grid">
<ul>
  <strong> <li><h1> Algemene Informatie </h1></li> </strong>
  <li>Betrouwbare online apotheek.</li>
  <li>Snelle en discrete levering.</li>
  <li>Altijd scherpe prijzen.</li>
  <li>Veilig winkelen met SSL.</li>
  <li>Bestel makkelijk via mobiel.</li>
  <li>Gecertificeerde kwaliteit.</li>
<br>
  <strong> <li><h1> Klantenservice </h1></li> </strong>
  <li>Service bereikbaar ma t/m vr.</li>
  <li>Vragen? Neem contact op.</li>
  <li>We denken met je mee.</li>
  <li>Check onze veelgestelde vragen.</li>
  <li>Je ontvangt direct bevestiging.</li>
  <li>Hulp bij het kiezen? Wij staan klaar.</li>
</ul>

<ul>
  <strong> <li><h1> Verzending & Retour </h1></li> </strong>
  <li>Voor 15:00 besteld, morgen in huis.</li>
  <li>Gratis verzending vanaf €50.</li>
  <li>Discrete verpakking gegarandeerd.</li>
  <li>Eenvoudig retourneren.</li>
  <li>Volg je pakket met Track & Trace.</li>
  <li>Verzorgd verzonden met PostNL.</li>
<br>
  <strong> <li><h1>Veiligheid & Betrouwbaarheod </h1></li> </strong>
  <li>Privacy staat bij ons voorop.</li>
  <li>Producten worden gecontroleerd.</li>
  <li>Jouw gegevens blijven veilig.</li>
  <li>Alleen erkende leveranciers.</li>
  <li>Onze apothekers waarborgen kwaliteit.</li>
  <li>Betaal veilig met iDEAL of kaart.</li>
</ul>

<ul>
  <strong> <li><h1> Gezondheid & Advies </h1></li> </strong>
  <li>Gezondheid begint bij ons.</li>
  <li>Ruim aanbod vitamines & supplementen.</li>
  <li>Ook EHBO-artikelen beschikbaar.</li>
  <li>Advies bij medicijngebruik.</li>
  <li>Lees onze gezondheidstips.</li>
  <li>Meld je aan voor de nieuwsbrief.</li>
<br>
  <strong> <li><h1> Contact & Bedrijf </h1></li> </strong>
  <li>Geregistreerde apotheek in NL.</li>
  <li>Bezoek enkel op afspraak.</li>
  <li>KvK- en BTW op contactpagina.</li>
  <li>Bereikbaar via mail & telefoon.</li>
  <li>Volg ons op social media.</li>
  <li>Bedankt voor je vertrouwen!</li>
</ul>

</footer>
<!-- Dit stukje is word niet gepakt door style.csss -->
<p class="copyright"> © 2025. Alle rechten voorbehouden.
Neem contact op via mborijnland@hotmail.nl </p>


<div id="react-chatbot"></div>

    <!-- Chatbot Code -> React Build -->
    <script src="chatbot/static/js/main.0eb252d4.js"></script>
</body>
</html>
