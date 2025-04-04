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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <nav>
        <!-- Navigatiebalk code -->
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