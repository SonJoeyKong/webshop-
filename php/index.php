<?php
session_start();
require_once "database.php";

// Error handling
error_reporting(E_ALL);
ini_set('display_errors', 1);

function logError($error, $type = 'ERROR') {
    $logFile = __DIR__ . '/logs/error.log';
    $timestamp = date('Y-m-d H:i:s');
    $message = "[$timestamp] [$type] $error\n";
    error_log($message, 3, $logFile);
}

// Haal featured producten op
try {
    $stmt = $conn->prepare("SELECT * FROM product ORDER BY id DESC LIMIT 6");
    $stmt->execute();
    $featured_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    logError($e->getMessage(), 'DATABASE');
    $error_message = "Er is een probleem met het laden van de producten.";
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ApotheCare - Online Medicijnen Bestellen</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/menu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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
        <?php if (!empty($featured_products)): ?>
            <section class="featured-products">
                <h2>Uitgelichte Producten</h2>
                <div class="products-grid">
                    <?php foreach($featured_products as $product): ?>
                        <div class="product-card">
                            <?php if (!empty($product['afbeelding'])): ?>
                                <img src="<?php echo htmlspecialchars($product['afbeelding']); ?>" 
                                     alt="<?php echo htmlspecialchars($product['product_naam']); ?>">
                            <?php endif; ?>
                            <h3><?php echo htmlspecialchars($product['product_naam']); ?></h3>
                            <p><?php echo htmlspecialchars($product['product_beschrijving']); ?></p>
                            <p class="price">€<?php echo number_format($product['product_prijs'], 2, ',', '.'); ?></p>
                            <?php if($product['product_voorraad'] > 0): ?>
                                <button class="btn btn-primary add-to-cart" 
                                        data-product-id="<?php echo htmlspecialchars($product['id']); ?>">
                                    In winkelwagen
                                </button>
                            <?php else: ?>
                                <button class="btn" disabled>Uitverkocht</button>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>

        <section class="features-grid">
            <div class="feature-card">
                <i class="fas fa-shopping-cart"></i>
                <h3>Online Bestellen</h3>
                <p>Eenvoudig uw medicijnen bestellen wanneer het u uitkomt</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-truck"></i>
                <h3>Snelle Bezorging</h3>
                <p>Binnen 24 uur bezorgd aan huis</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-comments"></i>
                <h3>Expert Advies</h3>
                <p>Online chat met onze apothekers</p>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h4>Contact</h4>
                <p><i class="fas fa-phone"></i> 0800-1234567</p>
                <p><i class="fas fa-envelope"></i> info@apothecare.nl</p>
            </div>
            <div class="footer-section">
                <h4>Links</h4>
                <ul>
                    <li><a href="privacy.php">Privacy</a></li>
                    <li><a href="voorwaarden.php">Voorwaarden</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> ApotheCare - Alle rechten voorbehouden</p>
        </div>
    </footer>

    <script src="/javascript/cart.js"></script>
</body>
</html>