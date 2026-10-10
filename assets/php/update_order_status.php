<?php
header('Content-Type: application/json');

$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'coffee_app';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['error' => 'Database connection failed.']));
}

// Ambil data dari request JSON
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['id'], $data['status'])) {
    echo json_encode(['error' => 'Invalid request data.']);
    exit;
}

$id = $data['id'];
$status = $data['status'];

$sql = "UPDATE orders SET status = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('si', $status, $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['error' => 'Failed to update order status.']);
}

$stmt->close();
$conn->close();
?>
