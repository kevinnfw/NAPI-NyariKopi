<?php
// Koneksi ke database
$server = "localhost";
$username = "root";
$password = "";
$database = "coffee_app";

$koneksi = mysqli_connect($server, $username, $password, $database);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Ambil data dari form
$username = $_POST['username'];
$password = $_POST['password'];

// Cek data di tabel customers
$query = "SELECT * FROM customers WHERE customer_name='$username' AND password='$password'";
$result = mysqli_query($koneksi, $query);

// Cek hasil login
if (mysqli_num_rows($result) > 0) {
    // Login berhasil
    header("Location: ../customer/customer_dashboard.html");
    exit();
} else {
    // Login gagal
    echo "Username atau password salah!";
}

// Tutup koneksi
mysqli_close($koneksi);
?>