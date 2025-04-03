<?php
// alleen beschikbaar als je ingelogd bent
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once "database.php";

$showAlert = false;
$showError = false;
$user_id = $_SESSION['user_id'];

// data voor in de velden
$stmt = $conn->prepare("SELECT naam, role FROM gebruiker WHERE id = :id");
$stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$username = htmlspecialchars($user['naam'] ?? '');
$role = htmlspecialchars($user['role'] ?? '');

// wachtwoord wijzigen
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = $_POST["current_password"];
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];

    // wachtwoord wat er nu is ophalen
    $stmt = $conn->prepare("SELECT wachtwoord FROM gebruiker WHERE id = :id");
    $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $current_password_hash = $user['wachtwoord'] ?? '';

    // Verifieer het huidige wachtwoord
    if (password_verify($current_password, $current_password_hash)) {
        // Check of het nieuwe wachtwoord overeenkomt
        if ($new_password === $confirm_password) {
            $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);

            // Wachtwoord updaten
            $stmt = $conn->prepare("UPDATE gebruiker SET wachtwoord = :wachtwoord WHERE id = :id");
            $stmt->bindParam(':wachtwoord', $new_password_hash);
            $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                echo "<script>alert('Wachtwoord succesvol gewijzigd!');</script>";
            } else {
                echo "<script>alert('Er is een fout opgetreden bij het wijzigen van het wachtwoord!');</script>";
            }
        } else {
            echo "<script>alert('Nieuwe wachtwoorden komen niet overeen!');</script>";
        }
    } else {
        echo "<script>alert('Huidig wachtwoord is onjuist!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ApotheCare | Profiel</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<nav> 
    <div class="nav-container"> 
        <div class="nav-left">
            <a href="../index.html" class="logo-link">
                <img src="../images/logo.png" alt="ApotheCare Logo" class="logo">
            </a>
            <a href="#">Producten</a>
            <a href="#">Chatbot</a>
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

<div class="settingsContainer">
    <div class="settingsBox">
        <h1 style="text-align: center;">Instellingen</h1>
        <?php if ($showAlert) echo "<p class='alert'>$showAlert</p>"; ?>
        <?php if ($showError) echo "<p class='error'>$showError</p>"; ?>

        <form action="profile.php" method="post">
            <label>Gebruikersnaam:</label><br>
            <input type="text" value="<?php echo $username; ?>" disabled><br><br>
            <label>Rol:</label><br>
            <input type="text" value="<?php echo $role; ?>" disabled><br><br>
            <label>Huidig wachtwoord:</label><br>
            <input type="password" name="current_password" required><br><br>
            <label>Nieuw wachtwoord:</label><br>
            <input type="password" name="new_password" required><br><br>
            <label>Bevestig nieuw wachtwoord:</label><br>
            <input type="password" name="confirm_password" required><br><br>
            <button type="submit">Wachtwoord wijzigen</button>
        </form>
        
        <form action="./functions/deleteAccount.php" method="post">
            <button type="submit" class="deleteButton">Account verwijderen</button>
        </form>
    </div>
</div>

</body>
</html>
