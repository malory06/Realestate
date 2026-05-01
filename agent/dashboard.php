<?php
session_start();
include('../config/db.php');

// 🔒 Restrict access
if (!isset($_SESSION['user']) || $_SESSION['role'] != 'agent') {
    header("Location: ../login.php");
    exit();
}

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Agent Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-4">

<h2>👤 Agent Dashboard</h2>
<p>Welcome, <?= $_SESSION['name'] ?></p>

<a href="properties.php" class="btn btn-primary">Manage My Properties</a>
<a href="../index.php" class="btn btn-secondary">Back to Website</a>
<a href="../logout.php" class="btn btn-danger">Logout</a>

</body>
</html>