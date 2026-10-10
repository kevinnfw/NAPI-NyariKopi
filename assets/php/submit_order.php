<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "coffee_app";

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil data dari formulir
$customer_name = $_POST['customer_name'];
$coffee_menu = $_POST['coffee_menu'];

// Masukkan data ke tabel
$sql = "INSERT INTO orders (customer_name, coffee_menu) VALUES ('$customer_name', '$coffee_menu')";

if ($conn->query($sql) === TRUE) {
    header("Location: orders.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
