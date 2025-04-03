<?php
session_start();
// zorgen dat alleen kan doen als je ingelogd bent
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

require_once "../database.php";

$user_id = $_SESSION['user_id'];

// account verwijderen uit de database
$stmt = $conn->prepare("DELETE FROM gebruiker WHERE id = :id");
$stmt->bindParam(':id', $user_id);
$stmt->execute();

// sessie kapot maken
session_unset();
session_destroy();
header("Location: ../index.php");
exit();
?>
