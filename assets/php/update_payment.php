<?php
header('Content-Type: application/json');

// Sambungkan ke database
require 'db_connection.php';

// Update semua pesanan berstatus "Pending" menjadi "Paid"
$query = "UPDATE orders SET status = 'Paid' WHERE status = 'Pending'";
$result = $conn->query($query);

if ($result) {
    echo json_encode(['success' => true, 'message' => 'All pending orders updated to Paid']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update orders']);
}

$conn->close();
?>
