<?php require 'login.php' ?>
<?php
session_start();
if (!isset($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true) {
    header("Location: index.html"); // Redirection vers le login si non connecté
    exit;
}
?>