<?php
session_start();
include('../config/db.php');

if ($_POST) {
    $title = $_POST['title'];
    $price = $_POST['price'];
    $location = $_POST['location'];
    $description = $_POST['description'];
    $image = $_FILES['image']['name'];

    move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/$image");

    $agent = $_SESSION['user'];

    $conn->query("INSERT INTO properties 
    (title, price, location, description, image, agent_email)
    VALUES ('$title', '$price', '$location', '$description', '$image', '$agent')");

    header("Location: properties.php");
}
?>

<form method="POST" enctype="multipart/form-data" class="container mt-4">
<input type="text" name="title" placeholder="Title" class="form-control mb-2" required>
<input type="text" name="price" placeholder="Price" class="form-control mb-2" required>
<input type="text" name="location" placeholder="Location" class="form-control mb-2" required>
<textarea name="description" class="form-control mb-2" placeholder="Description"></textarea>
<input type="file" name="image" class="form-control mb-2" required>
<button class="btn btn-success">Add Property</button>
</form>