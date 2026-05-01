<?php
include('../includes/admin_auth.php');
include('../config/db.php');

// Get stats
$users = $conn->query("SELECT COUNT(*) as total FROM users")->fetch_assoc();
$properties = $conn->query("SELECT COUNT(*) as total FROM properties")->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
        }
        .sidebar {
            height: 100vh;
            width: 220px;
            position: fixed;
            background: #111;
            padding: 20px;
        }
        .sidebar a {
            display: block;
            color: white;
            padding: 10px;
            text-decoration: none;
        }
        .sidebar a:hover {
            background: #333;
        }
        .main {
            margin-left: 240px;
            padding: 20px;
        }
        .card-box {
            padding: 20px;
            border-radius: 10px;
            color: white;
        }
    </style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h4 class="text-white">Admin Panel</h4>

    <a href="dashboard.php">Dashboard</a>
    <a href="properties/index.php">Properties</a>
    <a href="../index.php">View Site</a>
    <a href="../logout.php">Logout</a>
</div>

<!-- MAIN -->
<div class="main">

    <h2>Welcome, <?= $_SESSION['name'] ?></h2>
    
      <a href="agents.php" class="btn btn-warning">Manage Agent Requests</a>
    <div class="row mt-4">

        <div class="col-md-6">
            <div class="card-box bg-primary">
                <h4>Total Users</h4>
                <h2><?= $users['total'] ?></h2>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card-box bg-success">
                <h4>Total Properties</h4>
                <h2><?= $properties['total'] ?></h2>
            </div>
        </div>
       
    </div>

</div>

</body>
</html>