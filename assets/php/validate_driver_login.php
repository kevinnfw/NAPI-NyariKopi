<?php
session_start();

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "coffee_app";

$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil data dari form
$driver_id = $_POST['username'] ?? ''; // Field username dianggap ID
$driver_password = $_POST['password'] ?? '';

// Validasi input kosong
if (empty($driver_id) || empty($driver_password)) {
    header("Location: ../driver/driver_login.html?error=empty_fields");
    exit();
}

// Cek apakah id dan password cocok di tabel drivers
$sql = "SELECT * FROM drivers WHERE id = ? AND password = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Error preparing statement: " . $conn->error);
}

$stmt->bind_param("ss", $driver_id, $driver_password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    // Login berhasil
    $driver = $result->fetch_assoc();
    $_SESSION['driver_id'] = $driver['id'];
    $_SESSION['driver_name'] = $driver['name']; // Menyimpan nama driver jika diperlukan

    // Redirect ke halaman order.html
    header("Location: ../driver/driver_dashboard.html");
    exit();
} else {
    // Login gagal
    header("Location: ../driver/driver_login.html?error=invalid_credentials");
    exit();
}

$stmt->close();
$conn->close();
?>
