<?php
session_start();
require_once '../database.php';

global $conn; // Gebruik $conn i.p.v. $pdo

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Haal gegevens uit de POST
    $naam = $_POST['naam'];
    $adres = $_POST['adres'];
    $cart = $_SESSION['cart'] ?? [];

    if (empty($cart)) {
        echo "Winkelwagen is leeg.";
        exit;
    }

    // Zorg ervoor dat de gebruiker is ingelogd
    $gebruiker_id = $_SESSION['user_id'] ?? null; // Haal de user_id uit de sessie
    if (!$gebruiker_id) {
        echo "Je moet ingelogd zijn om een bestelling te plaatsen.";
        exit;
    }

    // Totaal prijs voor de bestelling
    $totaalPrijs = 0;

    // Loop door winkelwagen en verwerk de producten
    foreach ($cart as $productNaam => $item) {
        $product_id = getProductIdByName($productNaam);
        if (!$product_id) continue; // Als het product niet bestaat, overslaan

        $prijs = $item['price'];
        $aantal = $item['quantity'];
        $subtotaal = $prijs * $aantal;
        $totaalPrijs += $subtotaal;

        // Voeg bestelling toe
        $stmt = $conn->prepare("INSERT INTO bestelling 
            (gebruiker_id, product_id, prijs, status_bestelling, artikel_aantal, gebruiker_adres, totaal_prijs) 
            VALUES (?, ?, ?, 'open', ?, ?, ?)");
        $stmt->execute([$gebruiker_id, $product_id, $prijs, $aantal, $adres, $subtotaal]);

        // Update de voorraad
        $update = $conn->prepare("UPDATE product SET product_voorraad = product_voorraad - ? WHERE id = ?");
        $update->execute([$aantal, $product_id]);
    }

    unset($_SESSION['cart']); // Leeg de winkelwagen
    echo "<script>alert('Bedankt voor je bestelling!'); window.location.href = 'cart.php';</script>";
}

// Functie om product ID op te halen op basis van product naam
function getProductIdByName($productNaam) {
    global $conn;
    $stmt = $conn->prepare("SELECT id FROM product WHERE product_naam = ?");
    $stmt->execute([$productNaam]);
    $result = $stmt->fetch();
    return $result['id'] ?? null;
}
?>
