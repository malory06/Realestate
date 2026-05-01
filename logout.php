<?php
session_start();

$role = $_SESSION['role'] ?? null;

// Clear session
session_unset();
session_destroy();

// Redirect based on role
if ($role === 'admin') {
    header("Location: index.php"); 
    // admin goes to user interface (homepage)
} else {
    header("Location: index.php"); 
    // normal user goes to login/register page
}

exit();
?>