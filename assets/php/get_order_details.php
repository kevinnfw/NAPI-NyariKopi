<?php
header('Content-Type: application/json');

// Sambungkan ke database
require 'db_connection.php'; // Pastikan file ini benar

// Validasi input
if (!isset($_GET['order_id'])) {
    echo json_encode(['success' => false, 'message' => 'Order ID is required']);
    exit;
}

$order_id = intval($_GET['order_id']); // Pastikan ini integer

// Query untuk mengambil detail pesanan
$query = "SELECT * FROM orders WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $order = $result->fetch_assoc();
    echo json_encode(['success' => true, 'order' => $order]);
} else {
    echo json_encode(['success' => false, 'message' => 'Order not found']);
}

$stmt->close();
$conn->close();
?>
