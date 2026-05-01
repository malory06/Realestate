<?php
session_start();
include('config/db.php');

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];
$property_id = intval($_GET['id']);

// Check if exists
$check = $conn->query("SELECT id FROM favorites 
WHERE user_email='$user' AND property_id=$property_id");

if ($check->num_rows == 0) {
    $conn->query("INSERT INTO favorites (user_email, property_id)
    VALUES ('$user', $property_id)");
}

// 🔥 redirect back properly
header("Location: index.php");
exit();
?>