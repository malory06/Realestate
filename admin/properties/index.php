<?php
include('../../includes/admin_auth.php');
include('../../config/db.php');

$search = $_GET['search'] ?? '';

if ($search) {
    $result = $conn->query("
        SELECT * FROM properties 
        WHERE title LIKE '%$search%' 
        OR location LIKE '%$search%'
        ORDER BY id DESC
    ");
} else {
    if ($_SESSION['role'] == 'admin') {
    $result = $conn->query("
    SELECT properties.*, users.name AS agent_name 
    FROM properties
    LEFT JOIN users ON properties.agent_email = users.email
    ORDER BY properties.id DESC
");
} else {
    $user = $_SESSION['user'];
    $result = $conn->query("SELECT * FROM properties 
    WHERE agent_email='$user' ORDER BY id DESC");
}
}
?>



<form method="GET" class="mb-3 d-flex gap-2">
    <input type="text" name="search" class="form-control" placeholder="Search properties...">
    <button class="btn btn-primary">Search</button>
</form>

<!DOCTYPE html>
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<title>Manage Properties</title>
</head>

<body class="container mt-4">

<h2>Properties</h2>

<a href="create.php" class="btn btn-success mb-3">+ Add Property</a>
<a href="../dashboard.php" class="btn btn-secondary mb-3">
    ← Back to Dashboard
</a>
<table class="table table-bordered">
    <tr>
     <th>Picture</th>    
    <th>Title</th>
    <th>Location</th>
    <th>Price</th>
    <th>Agent</th>
    <th>Actions</th>
    </tr>  

    <?php while($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><img src="../../uploads/<?= $row['image'] ?>" width="80"></td>
        <td><?= $row['title'] ?></td>
        <td><?= $row['location'] ?></td>
        <td>$<?= $row['price'] ?></td>
        <td>
        <a href="../../agent_profile.php?email=<?= $row['agent_email'] ?>">
        <?= $row['agent_name'] ?? $row['agent_email'] ?>
        </a>
        </td>

        <td>
            <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
            <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
        </td>
    </tr>
    <?php } ?>

</table>

</body>
</html>