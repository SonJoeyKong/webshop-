<?php
session_start();
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afrekenen</title>
    <link rel="stylesheet" href="../../css/navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f1f1;
            margin: 0;
            padding: 0;
        }

        .checkout-container {
            display: flex;
            justify-content: space-between;
            padding: 40px;
        }

        .checkout-form,
        .checkout-products {
            flex: 1;
            padding: 20px;
            background-color: #20bca0;
            border-radius: 12px;
            color: white;
            margin: 0 10px;
        }

        .checkout-form label {
            display: block;
            margin-bottom: 15px;
        }

        .checkout-form input[type="text"],
        .checkout-form input[type="email"],
        .checkout-form input[type="tel"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 6px;
            border: none;
        }

        .submit-btn {
            background-color: #0d8b73;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 15px;
        }

        .betaal-opties {
            display: flex;
            gap: 20px;
            margin-top: 10px;
        }

        .product-blok {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .product-afbeelding {
            width: 100px;
            border-radius: 8px;
            display: block;
            margin-bottom: 10px;
        }

        h1 {
            text-align: center;
            margin-top: 40px;
        }
    </style>
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
                            <a href="cart.php"><i class="fa-solid fa-shopping-cart"></i> Winkelwagen</a>
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

<h1>Afrekenen</h1>

<div class="checkout-container">
    <!-- Formulier -->
    <div class="checkout-form">
        <form action="verwerk_betaling.php" method="POST">
            <label>Naam:
                <input type="text" name="naam" required>
            </label>
            <label>Adres:
                <input type="text" name="adres" required>
            </label>
            <label>Email Adres:
                <input type="email" name="email" required>
            </label>
            <label>Telefoon nummer:
                <input type="tel" name="telefoon" required>
            </label>
            <label>Betaal Methode:</label>
            <div class="betaal-opties">
                <label><input type="radio" name="betaalmethode" value="iDeal" required> iDeal</label>
                <label><input type="radio" name="betaalmethode" value="CreditCard"> Credit Card</label>
            </div>
            <button type="submit" class="submit-btn">Betalen</button>
        </form>
    </div>

    <!-- Winkelwagen producten -->
    <div class="checkout-products" id="checkout-products">
        <h2>Jouw Bestelling</h2>
        <!-- Producten komen hier via JS -->
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const products = JSON.parse(localStorage.getItem('cart')) || {};
    const container = document.getElementById('checkout-products');
    let totaalPrijs = 0;

    for (const [id, product] of Object.entries(products)) {
        const totaal = product.price * product.quantity;
        totaalPrijs += totaal;

        const productEl = document.createElement('div');
        productEl.classList.add('product-blok');
        productEl.innerHTML = `
            <img src="../../images/products/${product.image || 'placeholder.jpg'}" alt="${product.name}" class="product-afbeelding">
            <h3>${product.name}</h3>
            <p>${product.description || 'Geen beschrijving beschikbaar.'}</p>
            <p>Aantal: ${product.quantity}</p>
            <p>Prijs: €${product.price.toFixed(2)}</p>
            <p>Subtotaal: €${totaal.toFixed(2)}</p>
        `;
        container.appendChild(productEl);
    }

    const totaalEl = document.createElement('p');
    totaalEl.innerHTML = `<strong>Totaal prijs: €${totaalPrijs.toFixed(2)}</strong>`;
    container.appendChild(totaalEl);
});
</script>

</body>
</html>
