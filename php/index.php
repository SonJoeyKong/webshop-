<?php
session_start(); // Start de sessie
require_once "database.php";

// Haal producten op uit database
try {
    $stmt = $conn->prepare("SELECT * FROM product ORDER BY id DESC LIMIT 6");
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
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
                <a href="../index.html" class="logo-link">
                    <img src="../images/logo.png" alt="ApotheCare Logo" class="logo">
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

    <main class="main-content">
        <div class="products-grid">
            <?php foreach($products as $product): ?>
                <div class="product-card" data-product-id="<?php echo htmlspecialchars($product['id']); ?>">
                    <h3><?php echo htmlspecialchars($product['product_naam']); ?></h3>
                    <p><?php echo htmlspecialchars($product['product_beschrijving']); ?></p>
                    <p class="price">€<?php echo number_format($product['product_prijs'], 2, ',', '.'); ?></p>
                    <?php if($product['product_voorraad'] > 0): ?>
                        <button class="btn btn-primary add-to-cart">
                            In winkelwagen
                        </button>
                    <?php else: ?>
                        <button class="btn" disabled>Uitverkocht</button>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <script>
    // Auto-refresh producten elke 30 seconden
    setInterval(() => {
        fetch('api/getData.php')
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    // Update alleen als er wijzigingen zijn
                    const productsGrid = document.querySelector('.products-grid');
                    // Hier kun je de DOM updaten met nieuwe productgegevens
                }
            })
            .catch(error => console.error('Error:', error));
    }, 30000);
    </script>

</body>
</html>
