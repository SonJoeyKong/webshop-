<?php
require_once 'database.php'; // Gebruik database.php voor de verbinding

// Controleren of het formulier is ingediend
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';

    if (!empty($user) && !empty($pass)) {
        // Gebruiker zoeken in de database
        $stmt = $conn->prepare("SELECT * FROM gebruiker WHERE naam = :username");
        $stmt->bindParam(':username', $user);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && password_verify($pass, $result['wachtwoord'])) {
            // Inloggen geslaagd
            session_start();
            $_SESSION['user_id'] = $result['id'];
            $_SESSION['username'] = $result['naam'];
            header("Location: klanten.php");
            exit;

        } else {
            $error = "Ongeldige gebruikersnaam of wachtwoord.";
        }
    } else {
        $error = "Vul alle velden in.";
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
    <script src="https://kit.fontawesome.com/f7a63622f4.js" crossorigin="anonymous"></script> <!-- Icons library -->
</head>
<body>
    <nav> <!-- Navigatie Bar -->
        <div class="nav-container"> <!-- De foto & text die links staat. -->
            <div class="nav-left">
                <a href="../index.html" class="logo-link">
                    <img src="../images/logo.png" alt="ApotheCare Logo" class="logo">
                </a>
                <a href="">Producten</a>
                <a href="">Chatbot</a>
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
</body>
</html>