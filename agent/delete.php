<?php
session_start();
include('../config/db.php');

$user = $_SESSION['user'];
$id = $_GET['id'];

// 🔒 Only delete OWN property
$conn->query("DELETE FROM properties 
WHERE id=$id AND agent_email='$user'");

header("Location: properties.php");

