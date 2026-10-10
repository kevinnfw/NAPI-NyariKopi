<?php
// Koneksi ke database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'coffee_app';
$conn = new mysqli($host, $username, $password, $database);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari permintaan
$data = json_decode(file_get_contents('php://input'), true);
$orderId = $data['id'];
$status = $data['status'];

// Update status pesanan
$sql = "UPDATE orders SET status = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('si', $status, $orderId);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $stmt->error]);
}

// Tutup koneksi
$stmt->close();
$conn->close();
?>
