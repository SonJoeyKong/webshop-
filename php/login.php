<?php
session_start();
require_once 'database.php'; // Gebruik database.php voor de verbinding

// Controleren of het formulier is ingediend
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';

    if (!empty($user) && !empty($pass)) {
        // Gebruiker zoeken in de database
        $stmt = $conn->prepare("SELECT id, naam, wachtwoord, role FROM gebruiker WHERE naam = :username");
        $stmt->bindParam(':username', $user);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && password_verify($pass, $result['wachtwoord'])) {
            // Inloggen geslaagd
            session_start();
            $_SESSION['user_id'] = $result['id'];
            $_SESSION['username'] = $result['naam'];
            $_SESSION['role'] = $result['role'];
            header('Location: dashboard.php'); 
            exit;

        } else {
            $_SESSION['error'] = "Ongeldige gebruikersnaam of wachtwoord.";
        }
    } else {
        $_SESSION['error'] = "Vul alle velden in.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ApotheCare</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="chatbot/static/css/main.0e710cc4.css">

    <script src="https://kit.fontawesome.com/f7a63622f4.js" crossorigin="anonymous"></script> <!-- Icons library -->
</head>
<body>

<nav> <!-- Navigatie Bar -->
        <div class="nav-container"> <!-- De foto & text die links staat. -->
            <div class="nav-left">
                <a href="" class="logo-link">
                    <img src="../images/logo.png" alt="ApotheCare Logo" class="logo">
                </a>
                <a href="index.php">Apothecare</a>  
                <a href="">Producten</a>
            </div>

            <div class="search-container"> <!-- Input Field & Button die in het midden staan.  -->
                <div class="search-group">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input placeholder="Zoek een product...">
                    <button>Meer zorg</button>
                </div>
            </div>

            <div class="nav-right"> <!-- De links die rechts staan. -->
                <a href="login.php">Inloggen</a> <!-- Correcte link naar inlogpagina -->
                <a href="register.php">Registreren</a>
            </div>
        </div>
    </nav>

    <div class="login-container">
        <form class="login-form" action="../php/login.php" method="POST">
            <h1>Inloggen</h1>

            <!-- Foutmelding weergeven -->
            <?php
            if (isset($_SESSION['error'])) {
                echo '<p class="error-message">' . $_SESSION['error'] . '</p>';
                unset($_SESSION['error']); // Verwijder de foutmelding na het tonen
            }
            ?>

            <div class="form-group">
                <label for="username">Email Adres of naam:</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="password">Wachtwoord:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-actions">
                <a href="register.php" class="register-link">Registreren →</a>
                <button type="submit" class="login-btn">Inloggen</button>
            </div>
        </form>
    </div>

    <script>
    // Check of er een foutmelding is en zorg ervoor dat deze na 5 seconden verdwijnt
    window.onload = function() {
        var errorMessage = document.querySelector('.error-message');
        if (errorMessage) {
            setTimeout(function() {
                errorMessage.style.opacity = 0;
                setTimeout(function() {
                    errorMessage.style.display = 'none'; // Verberg de foutmelding na fade-out
                }, 500); // Wacht tot de fade-out is voltooid
            }, 5000); // Wacht 5 seconden voordat de fade-out begint
        }
    }
    </script>   
<footer style="position: fixed; bottom: 0; width: 100%; text-align: center; background-color: #f1f1f1; padding: 0px; box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);">
    <p class="copyright">© 2025. Alle rechten voorbehouden.
    Neem contact op via mborijnland@hotmail.nl</p>
</footer>

<div id="react-chatbot" style="position: fixed; bottom: 20px; right: 20px; z-index: 1000; padding:0; ,margin:0;"></div>

<!-- Chatbot Code -> React Build -->
<script src="chatbot/static/js/main.0eb252d4.js"></script>
</body>
</html>