<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: /admin/login.php");
    exit();
}
?>

<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
?>

<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header("Location: /Realestate/login.php");
    exit();
}
?>