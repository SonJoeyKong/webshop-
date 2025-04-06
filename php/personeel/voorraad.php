<?php
require_once '../database.php';
session_start();

// Verwijderen van product
if (isset($_GET['verwijder_id'])) {
    $id = $_GET['verwijder_id'];
    $stmt = $conn->prepare("DELETE FROM product WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: voorraad.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apothecare Voorraad</title>
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
                <a href="../index.php" class="logo-link">
                    <img src="../../images/logo.png" alt="ApotheCare Logo" class="logo">
                    <span>Apothecare</span>
                </a>
                <a href="../shop/producten.php">Producten</a>
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

    <div class="dashboard-grid">
        <div class="dashboard-header">
            <h1 class="dashboard-title">Voorraadbeheer</h1>
            <div class="dashboard-actions">
                <input type="text" class="search-bar" placeholder="Zoek een product..." id="searchInput">
                <a href="../functions/product_toevoegen.php" class="add-product-btn">+ Product toevoegen</a>
            </div>
        </div>

        <div class="inventory-list">
            <table id="productTable">
                <thead>
                    <tr>
                        <th>Productnaam</th>
                        <th>Beschrijving</th>
                        <th>Prijs</th>
                        <th>Voorraad</th>
                        <th>Acties</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM product ORDER BY product_voorraad";
                    $stmt = $conn->query($query);
                    while ($product = $stmt->fetch(PDO::FETCH_ASSOC)): 
                        $stockClass = $product['product_voorraad'] < 10 ? 'low' : ($product['product_voorraad'] < 30 ? 'medium' : 'good');
                    ?>
                    <tr class="<?= $stockClass ?>">
                        <td><?= htmlspecialchars($product['product_naam']) ?></td>
                        <td><?= htmlspecialchars($product['product_beschrijving']) ?></td>
                        <td>€<?= number_format($product['product_prijs'], 2, ',', '.') ?></td>
                        <td class="stock-cell">
                            <span class="stock-amount"><?= $product['product_voorraad'] ?></span>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: <?= min($product['product_voorraad'], 100) ?>%"></div>
                            </div>
                        </td>
                        <td class="actions">
                            <a href="../functions/product_bewerken.php?id=<?= $product['id'] ?>" class="edit-btn"><i class="fas fa-edit"></i></a>
                            <a href="voorraad.php?verwijder_id=<?= $product['id'] ?>" class="delete-btn" onclick="return confirm('Weet u zeker dat u dit product wilt verwijderen?')"><i class="fas fa-trash"></i></a>
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