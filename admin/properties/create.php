<?php
include('../../includes/admin_auth.php');
include('../../config/db.php');

if($_POST){
    $title = $_POST['title'];
    $price = $_POST['price'];
    $location = $_POST['location'];
    $description = $_POST['description'];

    $image = $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], "../../uploads/".$image);

    $conn->query("INSERT INTO properties (title, price, location, description, image)
    VALUES ('$title', '$price', '$location', '$description', '$image')");

    header("Location: index.php");
}
$agent = $_SESSION['user'];

$conn->query("INSERT INTO properties 
(title, price, location, description, image, agent_email)
VALUES ('$title', '$price', '$location', '$description', '$image', '$agent')");

?>


<form method="POST" enctype="multipart/form-data" class="container mt-4">

<h2>Add Property</h2>

<input class="form-control mb-2" name="title" placeholder="Title">
<input class="form-control mb-2" name="price" placeholder="Price">
<input class="form-control mb-2" name="location" placeholder="Location">
<textarea class="form-control mb-2" name="description" placeholder="Description"></textarea>

<input class="form-control mb-2" type="file" name="image">

<button class="btn btn-success">Save</button>

</form>