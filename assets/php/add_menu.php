<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "coffee_app";

// Koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$price = $_POST['price'];

// Proses upload gambar
$image_url = "";
if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
    $target_dir = "../assets/images/th.jpg";
    $target_file = $target_dir . basename($_FILES['image']['name']);
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        $image_url = "assets/images/th.jpg" . basename($_FILES['image']['name']);
    }
}

// Masukkan data ke tabel
$sql = "INSERT INTO menus (name, price, image_url) VALUES ('$name', '$price', '$image_url')";
if ($conn->query($sql) === TRUE) {
    echo "Menu added successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
