<?php
session_start();
include('../config/db.php');

if ($_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

// Get pending agents
$result = $conn->query("SELECT * FROM users WHERE role='pending_agent'");
?>

<!DOCTYPE html>
<html>
<head>
<title>Agent Approvals</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-4">

<h2>🕒 Pending Agent Requests</h2>

<table class="table table-bordered">
<tr>
    <th>Name</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Action</th>
</tr>

<?php while($row = $result->fetch_assoc()) { ?>
<tr>
    <td><?= $row['name'] ?></td>
    <td><?= $row['email'] ?></td>
    <td><?= $row['phone'] ?></td>
    <td>
        <a href="approve_agent.php?id=<?= $row['id'] ?>" class="btn btn-success btn-sm">Approve</a>
        <a href="reject_agent.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Reject</a>
    </td>
</tr>
<?php } ?>

</table>

<a href="dashboard.php" class="btn btn-secondary">← Back</a>

</body>
</html>