<?php
session_start();
include('config/db.php');

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];

$result = $conn->query("
    SELECT properties.* 
    FROM properties 
    JOIN favorites ON properties.id = favorites.property_id
    WHERE favorites.user_email = '$user'
");
?>

<!DOCTYPE html>
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<title>My Favorites</title>
</head>

<body class="container mt-4">

<h2>❤️ My Favorite Properties</h2>

<div class="row">
<?php while($row = $result->fetch_assoc()) { ?>
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