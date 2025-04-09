<?php
session_start();

// checken of je post hebt
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['cart'] = json_decode(file_get_contents('php://input'), true);
}

// cart ophalen uit de sessie
$cart = $_SESSION['cart'] ?? [];

// producten ophalen uit de database
$cartWithDetails = [];
foreach ($cart as $item) {
    if (isset($item['id'], $products[$item['id']])) {
        $product = $products[$item['id']];
        $cartWithDetails[] = [
            "name" => $product['name'],
            "price" => $product['price'],
            "quantity" => $item['quantity']
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="../../css/winkelwagen.css">
    <link rel="stylesheet" href="../../css/navbar.css">
    <link rel="stylesheet" href="chatbot/static/css/main.0e710cc4.css">

    <!-- Chatbot Style - React Build -->
    <link rel="stylesheet" href="../chatbot/static/css/main.0e710cc4.css">
    
    <!-- icons van het menu & voor dat input field -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- alpine.js voor het hamburger menutje -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <script>
        // cart ophalen uit localstorage
        document.addEventListener('DOMContentLoaded', () => {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            fetch('cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(cart)
            })
            .then(response => response.text())
            .then(data => {
                // location.reload(); // is ff uit omdat t glitchde
            })
            .catch(error => console.error('Error:', error));
        });
    </script>
</head>
<body>
<nav> 
        <div class="nav-container"> 
            <div class="nav-left">
                <a href="../index.php" class="logo-link">
                    <img src="../../images/logo.png" alt="ApotheCare Logo" class="logo">
                    <span>Apothecare</span>
                </a>
                <a href="producten.php">Producten</a>
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
                            <a href="shop/cart.php"><i class="fa-solid fa-shopping-cart"></i> Winkelwagen</a>
                            <a href="../signout.php"><i class="fa-solid fa-sign-out-alt"></i> Uitloggen</a>
                        </div>
                    </div>
                <?php else: ?> <!-- anders zie je dit alleen -->
                    <a href="login.php">Inloggen</a>
                    <a href="register.php">Registreren</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    
    <h1>Winkelwagen</h1>
        <div id="cart-container"></div>

        <p><strong>Totaalprijs:</strong> €<span id="total-price">0.00</span></p>

        <script>
        document.addEventListener('DOMContentLoaded', () => {
            const cart = JSON.parse(localStorage.getItem('cart')) || {};
            const cartContainer = document.getElementById('cart-container');
            const totalPriceSpan = document.getElementById('total-price');
            let total = 0;

            for (const [productId, item] of Object.entries(cart)) {
                const productDiv = document.createElement('div');
                productDiv.innerHTML = `
                    <h2>${productId}</h2>
                    <p>Prijs per stuk: €${item.price.toFixed(2)}</p>
                    <p>Aantal: ${item.quantity}</p>
                    <p>Subtotaal: €${(item.price * item.quantity).toFixed(2)}</p>
                    <hr>
                `;
                cartContainer.appendChild(productDiv);
                total += item.price * item.quantity;
            }

            totalPriceSpan.textContent = total.toFixed(2);
        });
        </script>

    <form action="afrekenen.php" method="GET">
        <button type="submit">Afrekenen</button>
    </form>

    <div id="react-chatbot"></div>

    <!-- Chatbot Code -> React Build -->
    <script src="../chatbot/static/js/main.0eb252d4.js"></script>
</body>
</html>
