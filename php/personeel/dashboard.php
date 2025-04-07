<?php
require_once '../database.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apothecare Dashboard</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/navbar.css">
    <link rel="stylesheet" href="../../css/test.css">

    <!-- Chartjs voor die bestellingen grfaph -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
        <!-- Header sectie -->
        <div class="dashboard-header">
            <h1 class="dashboard-title">Dashboard</h1>
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
                <span class="stat-label">Openstaande <a href="bestellingen.php" style="color: #26B9A2; text-decoration: none;">Bestellingen</a></span>
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
                <span class="stat-label">Totaal <a href="voorraad.php" style="color: #26B9A2; text-decoration: none;">Producten</a></span>
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
                <span class="stat-label">Totale <a href="klanten.php" style="color: #26B9A2; text-decoration: none;">Klanten</a></span>
            </div>
        </div>

        <!-- Hoofd content sectie -->
        <div class="main-content">
            <div class="orders-card">
                <h2 class="card-title">Totale Bestellingen per dag</h2>
                <canvas id="orders"></canvas>
            </div>

            <div class="inventory-card">
                <h2 class="card-title">Voorraad</h2>
                <div class="inventory-item">
                    <?php
                    $query = "SELECT product_naam, product_voorraad FROM product LIMIT 10";
                    $stmt = $conn->prepare($query);
                    $stmt->execute();
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if ($result) {
                        foreach ($result as $product) {
                            echo "<div class='inventory-row'>";
                            echo "<span class='product-name'> Product: " . htmlspecialchars($product['product_naam']) . "</span> ";
                            echo "<span class='product-stock'><strong style='color: #26B9A2;'>" . htmlspecialchars($product['product_voorraad']) . "</strong></span>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>Geen producten gevonden.</p>";
                    }
                    ?>
                </div>
                <a href="voorraad.php" class="more-link">Meer</a> 
            </div>
        </div>
    </div>
    <?php
        $query = "SELECT DATE_FORMAT(bestel_datum, '%d-%m-%Y') AS dag, COUNT(*) AS aantal 
                FROM bestelling 
                WHERE bestel_datum >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
                GROUP BY dag 
                ORDER BY bestel_datum ASC";

        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $labels = [];
        $data = [];
        foreach ($result as $row) {
            $labels[] = $row['dag'];
            $data[] = $row['aantal'];
        }
    ?>

    
<script>
    const ctx = document.getElementById('orders');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($labels); ?>,
            datasets: [{
                label: 'Bestellingen laatste 7 dagen',
                data: <?php echo json_encode($data); ?>,
                backgroundColor: 'rgba(38, 185, 162, 0.2)',
                borderColor: 'rgba(38, 185, 162, 1)',
                borderWidth: 2,
                fill: true,
                tension: 0.3,
                pointBackgroundColor: 'rgba(38, 185, 162, 1)',
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Aantal Bestellingen'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Datum'
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Bestellingen per dag (Laatste 7 dagen)'
                },
                legend: {
                    display: false
                }
            }
        }
    });
</script>

    <!-- AlpineJS voor dropdown functionaliteit -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
</body>
</html>