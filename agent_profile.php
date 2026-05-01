<?php
session_start();
include('config/db.php');

if (!isset($_GET['email'])) {
    header("Location: index.php");
    exit();
}

$email = $_GET['email'];

// Get agent info
$agent = $conn->query("
   SELECT name, email, phone FROM users
    WHERE email='$email' AND role='agent'
")->fetch_assoc();

if (!$agent) {
    echo "Agent not found";
    exit();
}

// Get agent properties
$properties = $conn->query("
    SELECT * FROM properties 
    WHERE agent_email='$email'
    ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Agent Profile</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-4">

<a href="index.php" class="btn btn-secondary mb-3">← Back</a>

<h2>👤 <?= $agent['name'] ?></h2>

<p><b>Email:</b> <?= $agent['email'] ?></p>
<p><b>Phone:</b> <?= $agent['phone'] ?></p>



<!-- CONTACT -->
<a href="mailto:<?= $agent['email'] ?>" class="btn btn-primary btn-sm">📧 Email</a>

<?php if(!empty($agent['phone'])) { ?>
<a href="https://wa.me/<?= $agent['phone'] ?>" target="_blank" class="btn btn-success btn-sm">
    💬 WhatsApp
</a>
<?php } ?>

<hr>

<h3>🏠 Properties by <?= $agent['name'] ?></h3>

<div class="row">
<?php while($row = $properties->fetch_assoc()) { ?>
    <div class="col-md-4">
        <div class="card mb-3">
            <img src="uploads/<?= $row['image'] ?>" class="card-img-top">
            <div class="card-body">
                <h5><?= $row['title'] ?></h5>
                <p><?= $row['location'] ?></p>
                <b>$<?= $row['price'] ?></b>
            </div>
        </div>
    </div>
<?php } ?>
</div>

</body>
</html>