<?php
// Konfigurasi koneksi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "coffee_app";

$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed']));
}

// Ambil data JSON dari request body
$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['customer_name'], $data['name'], $data['price'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit;
}

// Ambil data dari input
$customer_name = $conn->real_escape_string($data['customer_name']);
$menu_name = $conn->real_escape_string($data['name']);
$price = $conn->real_escape_string($data['price']);

// Masukkan ke tabel orders
$sql = "INSERT INTO orders (customer_name, menu_name, price) VALUES ('$customer_name', '$menu_name', '$price')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true, 'message' => 'Order saved successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
}

$conn->close();
?>
