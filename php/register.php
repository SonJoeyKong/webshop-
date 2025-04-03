<?php
require_once 'database.php'; // Gebruik database.php voor de verbinding

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $naam = $_POST['naam'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $adres = $_POST['adres'] ?? '';
    $telefoon_nummer = $_POST['telefoon_nummer'] ?? '';

    if (!empty($naam) && !empty($email) && !empty($password) && !empty($adres) && !empty($telefoon_nummer)) {
        // Controleren of de email al bestaat
        $stmt = $conn->prepare("SELECT * FROM gebruiker WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            die("Email is al geregistreerd.");
        }

        // Wachtwoord hashen
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Gebruiker toevoegen aan de database
        $stmt = $conn->prepare("INSERT INTO gebruiker (naam, email, wachtwoord, adres, telefoon_nummer) 
                                VALUES (:naam, :email, :wachtwoord, :adres, :telefoon_nummer)");
        $stmt->bindParam(':naam', $naam);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':wachtwoord', $hashed_password);
        $stmt->bindParam(':adres', $adres);
        $stmt->bindParam(':telefoon_nummer', $telefoon_nummer);

        if ($stmt->execute()) {
            header("Location: login.php");
            exit;
        } else {
            die("Er is een fout opgetreden bij het registreren.");
        }
    } else {
        die("Vul alle velden in.");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registreren - ApotheCare</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="register-container">
        <h1>Registreren</h1>
        <form class="register-form" action="../php/register.php" method="POST">
            <div class="form-group">
                <label for="naam">Naam:</label>
                <input type="text" id="naam" name="naam" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Wachtwoord:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="adres">Adres:</label>
                <textarea id="adres" name="adres" required></textarea>
            </div>
            <div class="form-group">
                <label for="telefoon_nummer">Telefoonnummer:</label>
                <input type="text" id="telefoon_nummer" name="telefoon_nummer" required>
            </div>
            <button type="submit" class="register-btn">Registreren</button>
        </form>
    </div>
</body>
</html>
