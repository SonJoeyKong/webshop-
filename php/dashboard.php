<?php
session_start();

// Check if the user is logged in and has a role
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'user') {
        // Redirect to klanten
        header('Location: klanten.php');
        exit();
    } elseif ($_SESSION['role'] === 'personeel') {
        // Redirect to personeel/dashboard.php
        header('Location: personeel/dashboard.php');
        exit();
    } else {
        // If role is not recognized, redirect to a default page or show an error
        echo "Onbekende rol. Neem contact op met de beheerder.";
        exit();
    }
} else {
    // If no session role is set, redirect to login page
    header('Location: login.php');
    exit();
}
?>