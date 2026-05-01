<?php
session_start();
include('config/db.php');

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];
$id = intval($_GET['id']); // safer

$conn->query("DELETE FROM favorites 
WHERE user_email='$user' AND property_id=$id");

// 🔥 IMPORTANT: go back to same page cleanly
header("Location: index.php");
exit();
?>