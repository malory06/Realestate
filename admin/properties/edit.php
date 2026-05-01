<?php
include('../../includes/admin_auth.php');
include('../../config/db.php');

$id = $_GET['id'];
$property = $conn->query("SELECT * FROM properties WHERE id=$id")->fetch_assoc();

if($_POST){
    $title = $_POST['title'];
    $price = $_POST['price'];
    $location = $_POST['location'];
    $description = $_POST['description'];

    if($_FILES['image']['name']){
        $image = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "../../uploads/".$image);

        $conn->query("UPDATE properties SET 
            title='$title',
            price='$price',
            location='$location',
            description='$description',
            image='$image'
            WHERE id=$id");
    } else {
        $conn->query("UPDATE properties SET 
            title='$title',
            price='$price',
            location='$location',
            description='$description'
            WHERE id=$id");
    }

    header("Location: index.php");
}
?>

<form method="POST" enctype="multipart/form-data" class="container mt-4">

<h2>Edit Property</h2>

<input class="form-control mb-2" name="title" value="<?= $property['title'] ?>">
<input class="form-control mb-2" name="price" value="<?= $property['price'] ?>">
<input class="form-control mb-2" name="location" value="<?= $property['location'] ?>">
<textarea class="form-control mb-2" name="description"><?= $property['description'] ?></textarea>

<img src="../../uploads/<?= $property['image'] ?>" width="120"><br><br>

<input class="form-control mb-2" type="file" name="image">

<button class="btn btn-primary">Update</button>

</form>