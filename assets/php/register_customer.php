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

// Simpan data ke tabel customers
$query = "INSERT INTO customers (username, password) VALUES ('$username', '$password')";
if (mysqli_query($koneksi, $query)) {
    echo "Pendaftaran berhasil!";
    echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location.href = '../customer/customer_login.html';</script>";
        exit();
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
}

// Tutup koneksi
mysqli_close($koneksi);
?>
