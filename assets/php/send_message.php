<?php
session_start();
$conn = new mysqli("localhost", "root", "", "coffee_app");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$driver_id = $_SESSION['driver_id'];
$message = $_POST['message'];

$stmt = $conn->prepare("INSERT INTO driver_messages (driver_id, message) VALUES (?, ?)");
$stmt->bind_param("is", $driver_id, $message);
$stmt->execute();
header("Location: ../driver/driver_dashboard.html");

$conn->close();
?>
