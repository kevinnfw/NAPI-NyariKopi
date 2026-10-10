<?php
session_start();
header('Content-Type: application/json');

// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'coffee_db');

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit();
}

// Ambil username dari sesi login
if (!isset($_SESSION['username'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit();
}

$username = $_SESSION['username'];

// Query untuk mendapatkan riwayat pesanan berdasarkan username
$sql = "SELECT menu_name, price, status, order_time FROM orders WHERE customer_name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();

$result = $stmt->get_result();
$orders = [];

while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}

echo json_encode(['success' => true, 'orders' => $orders]);
$stmt->close();
$conn->close();
?>
