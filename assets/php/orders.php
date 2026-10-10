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

// Query untuk mengambil semua data order
$sql = "SELECT * FROM orders WHERE status != 'PAID'";
$result = $conn->query($sql);

// Format hasil sebagai JSON
$orders = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
}
header('Content-Type: application/json');
echo json_encode($orders);

// Tutup koneksi
$conn->close();
?>
