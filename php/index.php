<?php
require_once '../database.php';
session_start();
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apothecare Dashboard</title>
    <link rel="stylesheet" href="../../css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
                <?php if (isset($_SESSION['username'])): ?>
                    <a href="cart.php">
                        <img src="../images/icons/cart_icon.png" alt="Winkelwagen Icoon" width="50px">
                    </a>

                    <div class="menu" x-data="{ open: false }">
                        <button @click="open = !open" class="menu-button">
                            <img src="../images/icons/menu_icon.png" alt="Menu Icoon" width="50px">
                        </button>

                        <div class="menu-dropdown" x-show="open" x-transition @click.away="open = false">
                            <a href="dashboard.php"><i class="fa-solid fa-user"></i> Dashboard</a>
                            <a href="cart.php"><i class="fa-solid fa-shopping-cart"></i> Winkelwagen</a>
                            <a href="signout.php"><i class="fa-solid fa-sign-out-alt"></i> Uitloggen</a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="login.php">Inloggen</a>
                    <a href="register.php">Registreren</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="dashboard-grid">
        <!-- Header sectie -->
        <div class="dashboard-header">
            <h1 class="dashboard-title">Dashboard</h1>
            <div class="dashboard-actions">
                <input type="text" class="search-bar" placeholder="Zoek een product...">
            </div>
        </div>

        <!-- Statistieken sectie -->
        <div class="stats-grid">
            <div class="stat-card open-bestellingen">
                <img src="../../images/icons/orders_icon.png" alt="Bestellingen icoon">
                <?php 
                $query = "SELECT COUNT(*) AS aantal FROM bestelling WHERE status_bestelling = 'open'";
                $stmt = $conn->prepare($query);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                echo "<p class='stat-number'>" . ($result['aantal'] ?? 0) . "</p>";
                ?>
                <span class="stat-label">Openstaande Bestellingen</span>
            </div>

            <div class="stat-card totale-omzet">
                <img src="../../images/icons/omzet_icon.png" alt="Omzet icoon">
                <?php 
                $query = "SELECT SUM(totaal_prijs) AS omzet FROM bestelling WHERE status_bestelling = 'verwerkt'";
                $stmt = $conn->prepare($query);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                echo "<p class='stat-number'>€" . number_format(($result['omzet'] ?? 0), 2, ',', '.') . "</p>";
                ?>
                <span class="stat-label">Totale Omzet</span>
            </div>

            <div class="stat-card totale-producten">
                <img src="../../images/icons/producten_icon.png" alt="Producten icoon">
                <?php 
                $query = "SELECT COUNT(*) AS aantal FROM product"; 
                $stmt = $conn->prepare($query);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                echo "<p class='stat-number'>" . ($result['aantal'] ?? 0) . "</p>";
                ?>
                <span class="stat-label">Totaal Producten</span>
            </div>

            <div class="stat-card totale-klanten">
                <img src="../../images/icons/klanten_icon.png" alt="Klanten icoon">
                <?php
                $query = "SELECT COUNT(*) AS aantal FROM gebruiker";
                $stmt = $conn->prepare($query);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                echo "<p class='stat-number'>" . ($result['aantal'] ?? 0) . "</p>";
                ?>
                <span class="stat-label">Totale Klanten</span>
            </div>
        </div>

        <!-- Hoofd content sectie -->
        <div class="main-content">
            <div class="orders-card">
                <h2 class="card-title">Totale Bestellingen per dag</h2>
                <div class="chart-placeholder"></div>
            </div>

            <div class="inventory-card">
                <h2 class="card-title">Voorraad</h2>
                <div class="inventory-item">
                    <h3>Product: Paracetamol</h3>
                    <div class="progress-container">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 36%"></div>
                        </div>
                        <span class="progress-text">360 / 1000</span>
                    </div>
                </div>
                <a href="#" class="more-link">Meer</a>
            </div>
        </div>
    </div>

    <!-- AlpineJS voor dropdown functionaliteit -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
</body>
</html>