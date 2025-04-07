<?php
// chatbot php
// autheur Joey
// versie 1.0
// datum 2023-10-01
// beschrijving: Dit is de chatbot van ApotheCare. Deze chatbot kan u helpen met het vinden van producten, informatie over medicijnen, bestellen en contact opnemen met de apotheek.
header('Content-Type: application/json');
require_once '../database.php';

function getProductInfo($product_name) {
    global $conn;
    try {
        $stmt = $conn->prepare("SELECT * FROM product WHERE product_naam LIKE :search LIMIT 1");
        $search = "%{$product_name}%";
        $stmt->bindParam(':search', $search);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        return null;
    }
}

$input = json_decode(file_get_contents('php://input'), true);
$message = strtolower($input['message'] ?? '');

$responses = [
    'greeting' => [
        'hallo' => 'Hallo! Hoe kan ik u helpen met onze apotheek diensten?',
        'hi' => 'Hallo! Hoe kan ik u helpen met onze apotheek diensten?',
        'goedemorgen' => 'Goedemorgen! Waarmee kan ik u helpen?',
        'goedemiddag' => 'Goedemiddag! Waarmee kan ik u helpen?',
        'goedeavond' => 'Goedeavond! Waarmee kan ik u helpen?'
    ],
    'help' => [
        'help' => 'Ik kan u helpen met: producten zoeken, informatie over medicijnen, bestellen, of contact met de apotheek.',
        'hulp' => 'Ik kan u helpen met: producten zoeken, informatie over medicijnen, bestellen, of contact met de apotheek.'
    ],
    'products' => [
        'producten' => 'We hebben verschillende medicijnen en gezondheidsproducten. Waar bent u naar op zoek?',
        'medicijnen' => 'We hebben verschillende medicijnen. Zoekt u iets specifieks?',
        'prijs' => 'Ik kan u helpen met prijsinformatie. Welk product zoekt u?'
    ],
    'order' => [
        'bestellen' => 'U kunt online bestellen via onze webshop. Wilt u weten hoe dat werkt?',
        'levering' => 'Wij leveren binnen 24 uur aan huis. Voor 16:00 besteld is morgen in huis.',
        'verzending' => 'De verzendkosten zijn €4,95. Bij bestellingen boven €50 is de verzending gratis.'
    ],
    'contact' => [
        'contact' => 'U kunt ons bereiken op 0800-1234567 of via info@apothecare.nl',
        'telefoon' => 'Ons telefoonnummer is 0800-1234567',
        'email' => 'Ons emailadres is info@apothecare.nl'
    ],
    'farewell' => [
        'doei' => 'Tot ziens! Heeft u nog vragen, stel ze gerust.',
        'dag' => 'Tot ziens! Heeft u nog vragen, stel ze gerust.',
        'bedankt' => 'Graag gedaan! Heeft u nog andere vragen?'
    ]
];

$response = ['message' => 'Sorry, ik begrijp uw vraag niet helemaal. Kunt u het anders formuleren?'];

// Check voor productinformatie
if (strpos($message, 'prijs') !== false || strpos($message, 'info') !== false) {
    foreach (['paracetamol', 'ibuprofen', 'aspirine', 'vitamine'] as $product) {
        if (strpos($message, $product) !== false) {
            $product_info = getProductInfo($product);
            if ($product_info) {
                $response = [
                    'message' => "Product: {$product_info['product_naam']}\n" .
                                "Prijs: €{$product_info['product_prijs']}\n" .
                                "Beschrijving: {$product_info['product_beschrijving']}\n" .
                                "Voorraad: {$product_info['product_voorraad']} stuks beschikbaar",
                    'type' => 'product'
                ];
            }
        }
    }
}

// Check voor andere responses
foreach ($responses as $category => $options) {
    foreach ($options as $keyword => $reply) {
        if (strpos($message, $keyword) !== false) {
            $response = ['message' => $reply, 'type' => $category];
            break 2;
        }
    }
}

echo json_encode($response); 