<?php
$conn = new mysqli("localhost", "root", "", "realestate");

if ($conn->connect_error) {
    die("DB failed");
}
?>