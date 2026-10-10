<?php
header('Content-Type: application/json');

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "coffee_app"; // Nama database

$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed: " . $conn->connect_error]);
    exit;
}

// Query untuk mengambil data notifikasi
$sql = "SELECT sender_id, message, created_at FROM messages ORDER BY created_at DESC";
$result = $conn->query($sql);

if ($result) {
    $notifications = [];
    while ($row = $result->fetch_assoc()) {
        $notifications[] = $row;
    }
    echo json_encode($notifications);
} else {
    http_response_code(500);
    echo json_encode(["error" => "Failed to fetch notifications: " . $conn->error]);
}

$conn->close();
?>
