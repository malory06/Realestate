<?php
session_start();
include('config/db.php');

$error = "";

// LOGIN PROCESS
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $input = trim($_POST['login']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=? OR name=?");
    $stmt->bind_param("ss", $input, $input);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {

        // BLOCK PENDING AGENTS
        if ($user['role'] == 'pending_agent') {
            $error = "Your agent account is pending approval.";
        } else {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user'] = $user['email'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];

            // REDIRECT BASED ON ROLE
            if ($user['role'] == 'admin') {
                header("Location: admin/dashboard.php");
            } elseif ($user['role'] == 'agent') {
                header("Location: agent/dashboard.php");
            } else {
                header("Location: index.php");
            }
            exit();
        }

    } else {
        $error = "Invalid email/username or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-5">

    <h2>Login</h2>

    <?php if (!empty($error)) { ?>
        <div class="alert alert-danger">
            <?= $error ?>
        </div>
    <?php } ?>

    <form method="POST">

        <input type="text" name="login" class="form-control mb-2"
               placeholder="Email or Username" required>

        <input type="password" name="password" class="form-control mb-2"
               placeholder="Password" required>

        <button class="btn btn-dark w-100">Login</button>

    </form>

    <p class="mt-3">
        Don't have an account? <a href="register.php">Register</a>
    </p>

</body>
</html>