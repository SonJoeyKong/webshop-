<?php
session_start();

// Check if cart data is sent via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['cart'] = json_decode(file_get_contents('php://input'), true);
}

// Retrieve cart data from session
$cart = $_SESSION['cart'] ?? [];

// Map cart items to include name and price
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
    <link rel="stylesheet" href="../../css/style.css">
    <script>
        // Fetch cart data from localStorage and send it to the server
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
                // Reload the page to reflect the updated cart
                location.reload();
            })
            .catch(error => console.error('Error:', error));
        });
    </script>
</head>
<body>
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

</body>
</html>
