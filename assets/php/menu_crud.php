<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "coffee_app";

// Koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Database connection failed: " . $conn->connect_error]));
}

// Ambil parameter `action` dari POST atau GET
$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($action == 'fetch') {
    // Query untuk mengambil semua data menu
    $sql = "SELECT * FROM menu";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $menus = [];
        while ($row = $result->fetch_assoc()) {
            $menus[] = $row;
        }
        echo json_encode($menus);
    } else {
        echo json_encode([]);
    }
    exit;
}

if ($action == 'add' || $action == 'update') {
    $name = $conn->real_escape_string($_POST['name']);
    $price = (float) $_POST['price'];
    $menuId = $_POST['menuId'] ?? null;

    // Proses upload gambar
    $imageUrl = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $targetDir = "../images/";
        $imageUrl = uniqid() . '_' . basename($_FILES['image']['name']); // Unique filename
        $targetFile = $targetDir . $imageUrl;

        // Pindahkan file yang diupload
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            echo json_encode(["status" => "error", "message" => "Failed to upload image"]);
            exit;
        }
    }

    if ($action == 'add') {
        // Tambahkan data menu baru
        $sql = "INSERT INTO menu (name, price, image_url) VALUES ('$name', $price, '$imageUrl')";
    } elseif ($action == 'update') {
        // Update data menu yang sudah ada
        $updateImage = $imageUrl ? ", image_url='$imageUrl'" : ""; // Hanya update image jika ada
        $sql = "UPDATE menu SET name='$name', price=$price $updateImage WHERE id=$menuId";
    }

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Menu successfully saved"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
    }
    exit;
}

if ($action == 'delete') {
    $id = (int) $_POST['id'];

    // Hapus data menu berdasarkan ID
    $sql = "DELETE FROM menu WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Menu successfully deleted"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
    }
    exit;
}

// Tutup koneksi database
$conn->close();
?>
