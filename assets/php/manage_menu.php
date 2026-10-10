<?php
$conn = new mysqli("localhost", "root", "", "coffee_app");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$action = $_POST['action'] ?? $_GET['action'];

if ($action === 'add') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stmt = $conn->prepare("INSERT INTO menu (name, price) VALUES (?, ?)");
    $stmt->bind_param("sd", $name, $price);
    $stmt->execute();
    header("Location: ../admin/admin_dashboard.html");
} elseif ($action === 'edit') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stmt = $conn->prepare("UPDATE menu SET name = ?, price = ? WHERE id = ?");
    $stmt->bind_param("sdi", $name, $price, $id);
    $stmt->execute();
    header("Location: ../admin/admin_dashboard.html");
} elseif ($action === 'delete') {
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM menu WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: ../admin/admin_dashboard.html");
}

$conn->close();
?>
