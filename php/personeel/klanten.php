<?php
session_start();
include_once "../database.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klanten Overzicht</title>
    <link rel="stylesheet" href="../../css/test.css">
    <link rel="stylesheet" href="../../css/navbar.css">
    <link rel="stylesheet" href="chatbot/static/css/main.0e710cc4.css">

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

    <div class="dashboard-grid">
        <div class="dashboard-header">
            <h1 class="dashboard-title">Klanten</h1>
            <div class="dashboard-actions">
                <input type="text" class="search-bar" placeholder="Zoek een klant..." id="searchInput">
            </div>
        </div>

        <div class="inventory-list">
            <table id="productTable">
                <thead>
                    <tr>
                        <th>Gebruiker ID</th>
                        <th>Naam</th>
                        <th>Email</th>
                        <th>Adres</th>
                        <th>Telefoon Nummer</th>
                        <th>Rol</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM gebruiker";
                    $stmt = $conn->query($query);
                    while ($product = $stmt->fetch(PDO::FETCH_ASSOC)): 
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($product['id']) ?></td>
                        <td><?= htmlspecialchars($product['naam']) ?></td>
                        <td><?= htmlspecialchars($product['email']) ?></td>
                        <td><?= htmlspecialchars($product['adres']) ?></td>
                        <td><?= htmlspecialchars($product['telefoon_nummer']) ?></td>
                        <td><?= htmlspecialchars($product['role']) ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Zoekfunctionaliteit
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchValue = this.value.toLowerCase();
            const rows = document.querySelectorAll('#productTable tbody tr');
            
            rows.forEach(row => {
                const productName = row.cells[0].textContent.toLowerCase();
                const productDesc = row.cells[1].textContent.toLowerCase();
                if (productName.includes(searchValue) || productDesc.includes(searchValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>
<footer style="position: fixed; bottom: 0; width: 100%; text-align: center; background-color: #f1f1f1; padding: 0px; box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);">
    <p class="copyright">© 2025. Alle rechten voorbehouden.
    Neem contact op via mborijnland@hotmail.nl</p>
</footer>

<div id="react-chatbot" style="position: fixed; bottom: 20px; right: 20px; z-index: 1000; padding:0; ,margin:0;"></div>

<!-- Chatbot Code -> React Build -->
<script src="chatbot/static/js/main.0eb252d4.js"></script>
</body>
</html>