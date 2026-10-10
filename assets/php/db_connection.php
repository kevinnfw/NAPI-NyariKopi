<?php
$servername = "localhost";
$username = "root"; // Sesuaikan username database Anda
$password = ""; // Sesuaikan password database Anda
$dbname = "coffee_app"; // Ganti dengan nama database Anda

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
