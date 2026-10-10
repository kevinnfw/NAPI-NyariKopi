<?php
header('Content-Type: application/json');
session_start();

$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'coffee_app';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['status' => 'error', 'message' => $conn->connect_error]));
}

// Ambil data dari permintaan
$input = json_decode(file_get_contents('php://input'), true);

$card = isset($input['card']) ? $input['card'] : null;
$cvv = isset($input['cvv']) ? $input['cvv'] : null;
$expiry = isset($input['expiry']) ? $input['expiry'] : null;

if (!$card || !$cvv || !$expiry) {
    echo json_encode(['status' => 'error', 'message' => 'Incomplete payment details']);
    exit;
}

// Ambil order_id dari sesi atau cari pesanan terakhir yang pending
$order_id = isset($_SESSION['last_order_id']) ? $_SESSION['last_order_id'] : null;

if (!$order_id) {
    $query = "SELECT id FROM orders WHERE status = 'pending' ORDER BY order_time DESC LIMIT 1";
    $result = $conn->query($query);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $order_id = $row['id'];
    }
}

// Jika tidak ada pesanan yang ditemukan
if (!$order_id) {
    echo json_encode(['status' => 'error', 'message' => 'No pending order found']);
    exit;
}

// Validasi data kartu (Contoh sederhana)
if (!preg_match('/^\d{16}$/', $card)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid card number']);
    exit;
}

if (!preg_match('/^\d{3}$/', $cvv)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid CVV']);
    exit;
}

if (!preg_match('/^\d{2}\/\d{2}$/', $expiry)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid expiry date format (use MM/YY)']);
    exit;
}

// Perbarui status pesanan menjadi "paid"
$update = "UPDATE orders SET status = 'paid' WHERE id = ? AND status = 'pending'";
$stmt = $conn->prepare($update);
$stmt->bind_param('i', $order_id);

if ($stmt->execute() && $stmt->affected_rows > 0) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Could not update order']);
}

$stmt->close();
$conn->close();
?>
