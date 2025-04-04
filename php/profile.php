<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once "database.php";

// Functie voor het loggen van fouten
function logError($error, $type = 'ERROR') {
    $logFile = __DIR__ . '/logs/error.log';
    $timestamp = date('Y-m-d H:i:s');
    $message = "[$timestamp] [$type] $error\n";
    error_log($message, 3, $logFile);
}

$notifications = [];
$user_id = $_SESSION['user_id'];

try {
    // Data voor in de velden
    $stmt = $conn->prepare("SELECT naam, email, role, adres, telefoon_nummer FROM gebruiker WHERE id = :id");
    $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        throw new Exception('Gebruiker niet gevonden');
    }
} catch(PDOException $e) {
    logError($e->getMessage(), 'DATABASE');
    $notifications[] = ['type' => 'error', 'message' => 'Er is een probleem met het ophalen van uw gegevens.'];
} catch(Exception $e) {
    logError($e->getMessage(), 'APPLICATION');
    $notifications[] = ['type' => 'error', 'message' => $e->getMessage()];
}

// Wachtwoord wijzigen
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $current_password = $_POST["current_password"] ?? '';
        $new_password = $_POST["new_password"] ?? '';
        $confirm_password = $_POST["confirm_password"] ?? '';

        // Validatie
        if (strlen($new_password) < 8) {
            throw new Exception('Wachtwoord moet minimaal 8 karakters bevatten');
        }

        // Huidig wachtwoord verifiëren
        $stmt = $conn->prepare("SELECT wachtwoord FROM gebruiker WHERE id = :id");
        $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $current_password_hash = $stmt->fetchColumn();

        if (!password_verify($current_password, $current_password_hash)) {
            throw new Exception('Huidig wachtwoord is onjuist');
        }

        if ($new_password !== $confirm_password) {
            throw new Exception('Nieuwe wachtwoorden komen niet overeen');
        }

        // Wachtwoord updaten
        $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE gebruiker SET wachtwoord = :wachtwoord WHERE id = :id");
        $stmt->bindParam(':wachtwoord', $new_password_hash);
        $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        $notifications[] = ['type' => 'success', 'message' => 'Wachtwoord succesvol gewijzigd!'];
    } catch(Exception $e) {
        logError($e->getMessage(), 'PASSWORD_UPDATE');
        $notifications[] = ['type' => 'error', 'message' => $e->getMessage()];
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
    <link rel="stylesheet" href="../css/menu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .profile-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }

        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #eee;
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: #e0e0e0;
            margin-right: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: #666;
        }

        .profile-info h1 {
            margin: 0;
            color: #333;
        }

        .profile-role {
            color: #666;
            font-size: 0.9rem;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }

        .form-section {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #555;
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }

        .notification {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 4px;
            display: flex;
            align-items: center;
        }

        .notification.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .notification.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .notification i {
            margin-right: 0.5rem;
        }

        .btn-group {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: #007bff;
            color: white;
        }

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }

        .delete-account {
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid #eee;
        }
    </style>
</head>
<body>
    <?php include 'includes/nav.php'; ?>

    <div class="profile-container">
        <div class="profile-header">
            <div class="profile-avatar">
                <i class="fas fa-user"></i>
            </div>
            <div class="profile-info">
                <h1><?php echo htmlspecialchars($user['naam']); ?></h1>
                <span class="profile-role"><?php echo htmlspecialchars($user['role']); ?></span>
            </div>
        </div>

        <?php foreach($notifications as $notification): ?>
            <div class="notification <?php echo $notification['type']; ?>">
                <i class="fas fa-<?php echo $notification['type'] === 'success' ? 'check-circle' : 'exclamation-circle'; ?>"></i>
                <?php echo htmlspecialchars($notification['message']); ?>
            </div>
        <?php endforeach; ?>

        <div class="form-grid">
            <div class="form-section">
                <h2>Persoonlijke Gegevens</h2>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
                </div>
                <div class="form-group">
                    <label>Adres</label>
                    <input type="text" value="<?php echo htmlspecialchars($user['adres']); ?>" disabled>
                </div>
                <div class="form-group">
                    <label>Telefoon</label>
                    <input type="tel" value="<?php echo htmlspecialchars($user['telefoon_nummer']); ?>" disabled>
                </div>
            </div>

            <div class="form-section">
                <h2>Wachtwoord Wijzigen</h2>
                <form action="profile.php" method="post">
                    <div class="form-group">
                        <label>Huidig wachtwoord</label>
                        <input type="password" name="current_password" required>
                    </div>
                    <div class="form-group">
                        <label>Nieuw wachtwoord</label>
                        <input type="password" name="new_password" required>
                    </div>
                    <div class="form-group">
                        <label>Bevestig nieuw wachtwoord</label>
                        <input type="password" name="confirm_password" required>
                    </div>
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary">Wachtwoord wijzigen</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="delete-account">
            <h2>Account Verwijderen</h2>
            <p>Let op: Deze actie kan niet ongedaan worden gemaakt.</p>
            <form action="./functions/deleteAccount.php" method="post" onsubmit="return confirm('Weet je zeker dat je je account wilt verwijderen?');">
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash-alt"></i> Account verwijderen
                </button>
            </form>
        </div>
    </div>
</body>
</html>
