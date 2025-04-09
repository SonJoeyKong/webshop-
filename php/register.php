<?php
require_once 'database.php'; // Gebruik database.php voor de verbinding

$errors = [];

$naam = '';
$email = '';
$password = '';
$adres = '';
$telefoon_nummer = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $naam = $_POST['naam'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $adres = $_POST['adres'] ?? '';
    $telefoon_nummer = $_POST['telefoon_nummer'] ?? '';

    if (empty($naam)) $errors['naam'] = "Naam is verplicht.";
    if (empty($email)) $errors['email'] = "Email is verplicht.";
    if (empty($password)) $errors['password'] = "Wachtwoord is verplicht.";
    if (empty($adres)) $errors['adres'] = "Adres is verplicht.";
    if (empty($telefoon_nummer)) $errors['telefoon_nummer'] = "Telefoonnummer is verplicht.";

    // Controleren of de email al bestaat
    if (!isset($errors['email'])) {
        $stmt = $conn->prepare("SELECT * FROM gebruiker WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $errors['email'] = "Email is al geregistreerd.";
        }
    }

    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

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
            $errors['algemeen'] = "Er is een fout opgetreden bij het registreren.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registreren - ApotheCare</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <script src="https://kit.fontawesome.com/f7a63622f4.js" crossorigin="anonymous"></script>
</head>
<body>
<nav>
    <div class="nav-container">
        <div class="nav-left">
            <a href="../index.html" class="logo-link">
                <img src="../images/logo.png" alt="ApotheCare Logo" class="logo">
            </a>
            <a href="index.php">Apothecare</a>
            <a href="">Producten</a>
            <a href="">Chatbot</a>
        </div>

        <div class="search-container">
            <div class="search-group">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input placeholder="Zoek een product...">
                <button>Meer zorg</button>
            </div>
        </div>

        <div class="nav-right">
            <a href="login.php">Inloggen</a>
            <a href="register.php">Registreren</a>
        </div>
    </div>
</nav>

<div class="register-container">
    <form class="register-form" action="register.php" method="POST">
        <h1>Registreren</h1>

        <?php if (!empty($errors['algemeen'])): ?>
            <div class="error-message"><?= htmlspecialchars($errors['algemeen']) ?></div>
        <?php endif; ?>

        <div class="form-group">
            <label for="naam">Naam:</label>
            <input type="text" id="naam" name="naam" required value="<?= htmlspecialchars($naam) ?>">
            <?php if (!empty($errors['naam'])): ?>
                <div class="error-message"><?= htmlspecialchars($errors['naam']) ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required value="<?= htmlspecialchars($email) ?>">
            <?php if (!empty($errors['email'])): ?>
                <div class="error-message"><?= htmlspecialchars($errors['email']) ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="password">Wachtwoord:</label>
            <input type="password" id="password" name="password" required>
            <?php if (!empty($errors['password'])): ?>
                <div class="error-message"><?= htmlspecialchars($errors['password']) ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="adres">Adres:</label>
            <input type="text" id="adres" name="adres" required value="<?= htmlspecialchars($adres) ?>">
            <?php if (!empty($errors['adres'])): ?>
                <div class="error-message"><?= htmlspecialchars($errors['adres']) ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="telefoon_nummer">Telefoonnummer:</label>
            <input type="text" id="telefoon_nummer" name="telefoon_nummer" required value="<?= htmlspecialchars($telefoon_nummer) ?>">
            <?php if (!empty($errors['telefoon_nummer'])): ?>
                <div class="error-message"><?= htmlspecialchars($errors['telefoon_nummer']) ?></div>
            <?php endif; ?>
        </div>

        <a href="login.php" class="register-link">Inloggen →</a>
        <button type="submit" class="register-btn">Registreren</button>
    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const naam = document.getElementById("naam");
        const email = document.getElementById("email");
        const password = document.getElementById("password");
        const telefoon = document.getElementById("telefoon_nummer");

        naam.addEventListener("input", () => {
            if (naam.value.length < 5) {
                naam.setCustomValidity("Naam moet minimaal 5 tekens bevatten.");
            } else {
                naam.setCustomValidity("");
            }
        });

        email.addEventListener("input", () => {
            if (!email.value.includes("@")) {
                email.setCustomValidity("Voer een geldig e-mailadres in.");
            } else {
                email.setCustomValidity("");
            }
        });

        password.addEventListener("input", () => {
            const pw = password.value;
            const strongPw = /^(?=.*[A-Z])(?=.*\d).{8,}$/;
            if (!strongPw.test(pw)) {
                password.setCustomValidity("Wachtwoord moet minstens 8 tekens bevatten, met een hoofdletter en een cijfer.");
            } else {
                password.setCustomValidity("");
            }
        });

        telefoon.addEventListener("input", () => {
            const phone = telefoon.value;
            if (!/^\d{10}$/.test(phone)) {
                telefoon.setCustomValidity("Telefoonnummer moet exact 10 cijfers bevatten.");
            } else {
                telefoon.setCustomValidity("");
            }
        });
    });
</script>
</body>
</html>