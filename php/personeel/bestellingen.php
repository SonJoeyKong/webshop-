<?php
session_start();
include_once "../database.php";

if (isset($_GET['verwijder_id'])) {
    $id = $_GET['verwijder_id'];
    $stmt = $conn->prepare("DELETE FROM bestelling WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: bestellingen.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../css/test.css">
    <link rel="stylesheet" href="../../css/navbar.css">

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
            <h1 class="dashboard-title">Bestellingen</h1>
            <div class="dashboard-actions">
                <input type="text" class="search-bar" placeholder="Zoek een bestelling..." id="searchInput">
            </div>
        </div>

        <div class="inventory-list">
            <table id="productTable">
                <thead>
                    <tr>
                        <th>Bestelling ID</th>
                        <th>Gebruiker ID</th>
                        <th>Producten</th>
                        <th>Prijs</th>
                        <th>Status</th>
                        <th>Aantal Artikelen</th>
                        <th>Adres</th>
                        <th>Totaal Prijs</th>
                        <th>Bestel Datum</th>
                        <th>Acties</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM bestelling ORDER BY bestel_datum DESC";
                    $stmt = $conn->query($query);
                    while ($product = $stmt->fetch(PDO::FETCH_ASSOC)): 
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($product['id']) ?></td>
                        <td><?= htmlspecialchars($product['gebruiker_id']) ?></td>
                        <td><?= htmlspecialchars($product['product_id']) ?></td>
                        <td><?= htmlspecialchars($product['prijs']) ?></td>
                        <td><?= htmlspecialchars($product['status_bestelling']) ?></td>
                        <td><?= htmlspecialchars($product['artikel_aantal']) ?></td>
                        <td><?= htmlspecialchars($product['gebruiker_adres']) ?></td>
                        <td><?= htmlspecialchars($product['totaal_prijs']) ?></td>
                        <td><?= htmlspecialchars($product['bestel_datum']) ?></td>
                        <td>
                            <a href="../functions/bestelling_bewerken.php?id=<?= $product['id'] ?>"><i class="fa-solid fa-pen" style="color: #26B9A2;"></i></a>
                            <a href="bestellingen.php?verwijder_id=<?= $product['id'] ?>" class="delete-btn" onclick="return confirm('Weet u zeker dat u deze bestelling wilt verwijderen?')"><i class="fas fa-trash" style="color: #26B9A2;"></i></a>
                        </td>
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
</html>