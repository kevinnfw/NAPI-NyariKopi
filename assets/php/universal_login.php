
<?php
include 'db_connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userType = $_POST['userType'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $table = '';
    $redirect = '';

    // Determine table and redirect based on user type
    switch ($userType) {
        case 'admin':
            $table = 'admins';
            $redirect = '../admin/admin_dashboard.html';
            break;
        case 'driver':
            $table = 'drivers';
            $redirect = '../driver/driver_dashboard.html';
            break;
        case 'customer':
            $table = 'customers';
            $redirect = '../customer/customer_dashboard.html';
            break;
        default:
            echo json_encode(['success' => false, 'message' => 'Invalid user type.']);
            exit();
    }

    // Prepare SQL statement
    $sql = "SELECT * FROM $table WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $username, $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Validate password and set session
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;
        $_SESSION['role'] = $userType;
        header("Location: $redirect");
        exit();
    } else {
        echo '<script>alert("Invalid credentials. Please try again."); window.location.href="../login.html";</script>';
    }
}
?>
