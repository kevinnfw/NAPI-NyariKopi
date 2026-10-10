<?php
session_start();
include 'db_connection.php';

// Ambil data dari form login admin
$admin_username = $_POST['username'];
$admin_password = $_POST['password'];

// Validasi input
if (empty($admin_username) || empty($admin_password)) {
    echo json_encode(['success' => false, 'message' => 'Username atau password tidak boleh kosong']);
    exit;
}

// Ambil data admin dari tabel `admin`
$sql = "SELECT username, password FROM admin WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $admin_username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Verifikasi password
    if (password_verify($admin_password, $row['password'])) {
        // Simpan username admin ke sesi
        $_SESSION['admin_username'] = $row['username']; // Perhatikan sesi admin
        error_log("DEBUG: Login admin berhasil, username: " . $_SESSION['admin_username']);
        echo json_encode(['success' => true, 'message' => 'Login admin berhasil']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Password salah']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Username admin tidak ditemukan']);
}

$stmt->close();
$conn->close();
?>
