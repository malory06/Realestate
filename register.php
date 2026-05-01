<?php
session_start();
include('config/db.php');

$message = "";

if ($_POST) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $phone = $_POST['phone'];
     $role = $_POST['role'];
    $phone = trim($phone);

// If starts with 0 → convert to Ghana format
if (substr($phone, 0, 1) == '0') {
    $phone = '233' . substr($phone, 1);
}



// Remove + if user added it
   $phone = str_replace('+', '', $phone);

    $check = $conn->query("SELECT * FROM users WHERE email='$email'");

    if ($check->num_rows > 0) {
        $message = "Email already exists!";
    } else {
      $conn->query("INSERT INTO users (name, email, password, phone, role)
      VALUES ('$name', '$email', '$password', '$phone', '$role')");

        $_SESSION['user'] = $email;
        $_SESSION['name'] = $name;

        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<title>Register</title>
</head>

<body class="container mt-5">

<h2>Create Account</h2>

<?php if($message){ ?>
<div class="alert alert-warning"><?= $message ?></div>
<?php } ?>

<form method="POST">
    <input class="form-control mb-2" name="name" placeholder="Full Name" required>
    <input class="form-control mb-2" name="email" placeholder="Email" required>
    <input class="form-control mb-2" type="password" name="password" placeholder="Password" required>
    <input type="text" name="phone" placeholder="Phone number" class="form-control">

    <label class="mt-2">Register as:</label>

<select name="role" class="form-control mb-2" required>
    <option value="user">User</option>
    <option value="pending_agent">Agent (requires approval)</option>
</select>

    <button class="btn btn-success">Register</button>
</form>

</body>
</html>
