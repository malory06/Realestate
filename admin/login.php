<?php
session_start();
include('../config/db.php');

if($_POST){
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $q = $conn->query("SELECT * FROM users WHERE email='$email'");
    $u = $q->fetch_assoc();

    if($u && password_verify($pass, $u['password'])){
        $_SESSION['admin'] = $email;
        header("Location: dashboard.php");
    } else {
        echo "Invalid login";
    }
}
?>

<form method="POST">
    <h2>Admin Login</h2>
    <input name="email" placeholder="Email"><br>
    <input name="password" type="password"><br>
    <button>Login</button>
</form>