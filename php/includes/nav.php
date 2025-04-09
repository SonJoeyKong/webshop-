<?php
// Controleer of sessie al gestart is
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<nav>
    <div class="nav-container">
        <div class="nav-left">
            <a href="/php/index.php" class="logo-link">
                <img src="/images/logo.png" alt="ApotheCare Logo" class="logo">
                <span>Apothecare</span>
            </a>
            <a href="/php/shop/producten.php">Producten</a>
            <a href="/php/chatbot.php">Chatbot</a>
        </div>
        
        <div class="search-container">
            <div class="search-group">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="search" placeholder="Zoek een product..." id="searchInput">
                <button class="search-btn">Zoeken</button>
            </div>
        </div>

        <div class="nav-right">
            <?php if (isset($_SESSION['username'])): ?>
                <!-- Winkelwagen knop -->
                <a href="/php/shop/cart.php" class="cart-icon">
                    <img src="/images/icons/cart_icon.png" alt="Winkelwagen" width="50px">
                    <?php
                    try {
                        $stmt = $conn->prepare("SELECT COUNT(*) FROM winkelwagen WHERE user_id = :user_id");
                        $stmt->bindParam(':user_id', $_SESSION['user_id']);
                        $stmt->execute();
                        $cart_count = $stmt->fetchColumn();
                        if ($cart_count > 0) {
                            echo "<span class='cart-count'>$cart_count</span>";
                        }
                    } catch(PDOException $e) {
                        // Stil falen voor UX
                    }
                    ?>
                </a>

                <!-- Dropdown menu -->
                <div class="menu" x-data="{ open: false }">
                    <button @click="open = !open" class="menu-button">
                        <img src="/images/icons/menu_icon.png" alt="Menu" width="50px">
                    </button>
                    <div class="menu-dropdown" x-show="open" @click.away="open = false">
                        <a href="/php/profile.php"><i class="fa-solid fa-user"></i> Profiel</a>
                        <a href="/php/shop/cart.php"><i class="fa-solid fa-shopping-cart"></i> Winkelwagen</a>
                        <?php if ($_SESSION['role'] === 'personeel'): ?>
                            <a href="/php/personeel/dashboard.php"><i class="fa-solid fa-gauge"></i> Dashboard</a>
                        <?php endif; ?>
                        <a href="/php/signout.php"><i class="fa-solid fa-sign-out-alt"></i> Uitloggen</a>
                    </div>
                </div>
            <?php else: ?>
                <a href="/php/login.php">Inloggen</a>
                <a href="/php/register.php">Registreren</a>
            <?php endif; ?>
        </div>
    </div>
    <footer style="position: fixed; bottom: 0; width: 100%; text-align: center; background-color: #f1f1f1; padding: 0px; box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);">
    <p class="copyright">© 2025. Alle rechten voorbehouden.
    Neem contact op via mborijnland@hotmail.nl</p>
</footer>

<div id="react-chatbot" style="position: fixed; bottom: 20px; right: 20px; z-index: 1000; padding:0; ,margin:0;"></div>

<!-- Chatbot Code -> React Build -->
<script src="chatbot/static/js/main.0eb252d4.js"></script>
</body>
</nav> 