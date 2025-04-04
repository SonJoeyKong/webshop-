<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
require_once '../database.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Haal producten op
    $stmt = $pdo->prepare("SELECT * FROM producten ORDER BY datum DESC");
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Haal bestellingen op
    $stmt = $pdo->prepare("SELECT * FROM bestellingen WHERE user_id = :userId");
    $stmt->bindParam(':userId', $_SESSION['user_id'] ?? null);
    $stmt->execute();
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'products' => $products,
        'orders' => $orders
    ]);
} catch(PDOException $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?> 