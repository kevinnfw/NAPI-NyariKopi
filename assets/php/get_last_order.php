<?php
header('Content-Type: application/json');
include 'db_connection.php';

$result = $conn->query("SELECT * FROM orders ORDER BY id DESC LIMIT 1");
if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'No orders found']);
} else {
    $order = $result->fetch_assoc();
    echo json_encode(['success' => true, 'order' => $order]);
}
$conn->close();
?>
