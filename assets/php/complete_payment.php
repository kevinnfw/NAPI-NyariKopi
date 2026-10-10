<?php
header('Content-Type: application/json');
session_start();
include 'db_connection.php';

$order_id = isset($_SESSION['last_order_id']) ? $_SESSION['last_order_id'] : null;

if (!$order_id) { 
    echo json_encode(['status' => 'error', 'message' => 'No order found to update']);
    exit;
}

$sql = "UPDATE orders SET status = 'Paid' WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);

if ($stmt->execute() && $stmt->affected_rows > 0) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update order']);
}

$stmt->close();
$conn->close();
?>
