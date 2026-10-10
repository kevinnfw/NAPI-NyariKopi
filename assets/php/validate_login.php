<?php
session_start();

// Koneksi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "coffee_app";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil data dari form login
$user_username = $_POST['username'] ?? '';
$user_password = $_POST['password'] ?? '';
$user_type = $_POST['user_type'] ?? '';

if (empty($user_username) || empty($user_password) || empty($user_type)) {
    header("Location: ../admin/admin_login.html?error=empty_fields");
    exit();
}

// Tentukan tabel berdasarkan jenis pengguna
$table = '';
switch ($user_type) {
    case 'admin':
        $table = 'admins';
        break;
    case 'driver':
        $table = 'drivers';
        break;
    case 'customer':
        $table = 'customers';
        break;
    default:
        header("Location: ../admin/admin_login.html?error=invalid_user_type");
        exit();
}

// Validasi kredensial pengguna
$sql = "SELECT * FROM $table WHERE username = ? AND password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $user_username, $user_password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    $_SESSION['username'] = $user['username'];
    $_SESSION['user_type'] = $user_type;

    // Redirect ke dashboard sesuai jenis pengguna
    switch ($user_type) {
        case 'admin':
            header("Location: ../../assets/admin/admin_dashboard.html");
            break;
        case 'driver':
            header("Location: ../../assets/driver/driver_dashboard.html");
            break;
        case 'customer':
            header("Location: ../../assets/customer/customer_dashboard.html");
            break;
    }
    exit();
} else {
   // If login failed, display error message
   echo '<script>alert("Invalid Driver ID or Password"); window.location.href="../admin/admin_login.html";</script>';
}

$conn->close();
?>
