<?php
session_start();
include('../config/db.php');

if (!isset($_SESSION['user']) || $_SESSION['role'] != 'agent') {
    header("Location: ../login.php");
    exit();
}

$user = $_SESSION['user'];

// 🔥 ONLY AGENT'S PROPERTIES
$result = $conn->query("
    SELECT * FROM properties 
    WHERE agent_email='$user' 
    ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>My Properties</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-4">

<h3>🏠 My Properties</h3>

<a href="create.php" class="btn btn-success mb-3">+ Add Property</a>
<a href="dashboard.php" class="btn btn-secondary mb-3">← Back</a>

<table class="table table-bordered">
<tr>
    <th>Title</th>
    <th>Location</th>
    <th>Price</th>
    <th>Actions</th>
</tr>

<?php while($row = $result->fetch_assoc()) { ?>
<tr>
    <td><?= $row['title'] ?></td>
    <td><?= $row['location'] ?></td>
    <td>$<?= $row['price'] ?></td>
    <td>
        <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
        <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
    </td>
</tr>
<?php } ?>

</table>

</body>
</html>