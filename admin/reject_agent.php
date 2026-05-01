<?php
session_start();
include('../config/db.php');

if ($_SESSION['role'] != 'admin') {
    exit();
}

$id = $_GET['id'];

$conn->query("DELETE FROM users WHERE id=$id");

header("Location: agents.php");