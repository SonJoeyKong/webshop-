<?php
require_once 'database.php'; // Verbind met de database

$errors = []; // Hier slaan we foutmeldingen op

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Waarden ophalen en spaties verwijderen
    $naam = trim($_POST['naam'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $adres = trim($_POST['adres'] ?? '');
    $telefoon_nummer = trim($_POST['telefoon_nummer'] ?? '');

    // Validatie uitvoeren
    if (empty($naam)) {
        $errors['naam'] = "Naam is verplicht.";
    } elseif (strlen($naam) < 3) {
        $errors['naam'] = "Naam moet minimaal 3 tekens zijn.";
    }

    if (empty($email)) {
        $errors['email'] = "E-mailadres is verplicht.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Ongeldig e-mailadres.";
    }

    if (empty($password)) {
        $errors['password'] = "Wachtwoord is verplicht.";
    } elseif (strlen($password) < 6) {
        $errors['password'] = "Wachtwoord moet minimaal 6 tekens zijn.";
    }

    if (empty($adres)) {
        $errors['adres'] = "Adres is verplicht.";
    }

    if (empty($telefoon_nummer)) {
        $errors['telefoon_nummer'] = "Telefoonnummer is verplicht.";
    } elseif (!preg_match('/^[0-9]{10}$/', $telefoon_nummer)) {
        $errors['telefoon_nummer'] = "Telefoonnummer moet uit 10 cijfers bestaan.";
    }

    // Als geen fouten, doorgaan
    if (empty($errors)) {
        // Check of email al bestaat
        $stmt = $conn->prepare("SELECT * FROM gebruiker WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $errors['email'] = "Dit e-mailadres is al geregistreerd.";
        } else {
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
                $errors['algemeen'] = "Er ging iets mis tijdens het registreren.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ApotheCare</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .error-message {
            color: red;
            font-size: 0.9em;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <form class="register-form" action="register.php" method="POST">
            <h1>Registreren</h1>

            <?php if (!empty($errors['algemeen'])): ?>
                <div class="error-message"><?= htmlspecialchars($errors['algemeen']) ?></div>
            <?php endif; ?>

            <div class="form-group">
                <label for="naam">Naam:</label>
                <input type="text" id="naam" name="naam" value="<?= htmlspecialchars($naam ?? '') ?>" required>
                <?php if (!empty($errors['naam'])): ?>
                    <div class="error-message"><?= htmlspecialchars($errors['naam']) ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>" required>
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
                <textarea id="adres" name="adres" required><?= htmlspecialchars($adres ?? '') ?></textarea>
                <?php if (!empty($errors['adres'])): ?>
                    <div class="error-message"><?= htmlspecialchars($errors['adres']) ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="telefoon_nummer">Telefoonnummer:</label>
                <input type="text" id="telefoon_nummer" name="telefoon_nummer" value="<?= htmlspecialchars($telefoon_nummer ?? '') ?>" required>
                <?php if (!empty($errors['telefoon_nummer'])): ?>
                    <div class="error-message"><?= htmlspecialchars($errors['telefoon_nummer']) ?></div>
                <?php endif; ?>
            </div>

            <a href="login.php" class="register-link">Al een account? Inloggen →</a>
            <button type="submit" class="register-btn">Registreren</button>
        </form>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", () => {
        const naam = document.getElementById("naam");
        const email = document.getElementById("email");
        const password = document.getElementById("password");
        const telefoon = document.getElementById("telefoon_nummer");

        // Check of naam lang genoeg is
        naam.addEventListener("input", () => {
            if (naam.value.length < 5) {
                naam.setCustomValidity("Naam moet minimaal 5 tekens bevatten.");
            } else {
                naam.setCustomValidity("");
            }
        });

        // Check of e-mail correct is
        email.addEventListener("input", () => {
            if (!email.value.includes("@")) {
                email.setCustomValidity("Voer een geldig e-mailadres in.");
            } else {
                email.setCustomValidity("");
            }
        });

        // Check of wachtwoord sterk is
        password.addEventListener("input", () => {
            const pw = password.value;
            const strongPw = /^(?=.*[A-Z])(?=.*\d).{8,}$/;
            if (!strongPw.test(pw)) {
                password.setCustomValidity("Wachtwoord moet minstens 8 tekens bevatten, met een hoofdletter en een cijfer.");
            } else {
                password.setCustomValidity("");
            }
        });

        // Check of telefoonnummer 10 cijfers heeft
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
