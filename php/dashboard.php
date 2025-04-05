<?php
session_start();

// Check if the user is logged in and has a role
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'user') {
        // Redirect to klanten
        header('Location: klanten/dashboard.php');
        exit();
    } elseif ($_SESSION['role'] === 'personeel') {
        header('Location: personeel/dashboard.php');
        exit();
    } else {
        echo "Onbekende rol. Neem contact op met de beheerder.";
        exit();
    }
} else {
    header('Location: login.php');
    exit();
}
?>