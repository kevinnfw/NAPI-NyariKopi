<?php
session_start();
include 'db_connection.php';

// Ambil data dari form login pelanggan
$username = $_POST['username'];
$password = $_POST['password'];

// Validasi input
if (empty($username) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Username atau password tidak boleh kosong']);
    exit;
}

// Ambil data pelanggan dari tabel `customers`
$sql = "SELECT username, password FROM customers WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Verifikasi password
    if (password_verify($password, $row['password'])) {
        // Simpan username pelanggan ke sesi
        $_SESSION['customer_username'] = $row['username']; // Sesi pelanggan
        error_log("DEBUG: Login pelanggan berhasil, username: " . $_SESSION['customer_username']);
        echo json_encode(['success' => true, 'message' => 'Login berhasil']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Password salah']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Username tidak ditemukan']);
}

$stmt->close();
$conn->close();
?>
