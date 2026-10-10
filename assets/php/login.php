
<?php
session_start();
include("db_connection.php"); // Assuming a db_connection.php file exists

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $password = md5($_POST['password']); // MD5 used for password hashing (adjust if database uses different hashing)
    $role = $_POST['role']; // Added role to determine user type

    $table = "";
    $redirect_url = "";

    if ($role == "admin") {
        $table = "admins";
        $redirect_url = "../admin/admin_dashboard.html";
    } elseif ($role == "driver") {
        $table = "drivers";
        $redirect_url = "../driver/driver_dashboard.html";
    } elseif ($role == "customer") {
        $table = "customers";
        $redirect_url = "../customer/customer_dashboard.html";
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid role"]);
        exit;
    }

    $sql = "SELECT * FROM $table WHERE id = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $id, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['user_id'] = $id;
        $_SESSION['role'] = $role;
        echo json_encode(["status" => "success", "redirect" => $redirect_url]);
    } else {
        echo json_encode(["status" => "error", "message" => "Akun anda tidak ditemukan"]);
    }

    $stmt->close();
    $conn->close();
}
?>
