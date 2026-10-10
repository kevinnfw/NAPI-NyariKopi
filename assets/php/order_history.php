<?php
session_start();
include 'database_connection.php';

if (!isset($_SESSION['username'])) {
    header("Location: customer_login.html");
    exit;
}

$customer_id = $_SESSION['customer_id'];
$stmt = $pdo->prepare("SELECT * FROM orders WHERE customer_id = ?");
$stmt->execute([$customer_id]);
$orders = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <style>
        /* Masukkan CSS untuk tabel */
    </style>
</head>
<body>
    <h1>Order History</h1>
    <table>
        <thead>
            <tr>
                <th>Menu Name</th>
                <th>Price</th>
                <th>Status</th>
                <th>Order Time</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo htmlspecialchars($order['menu_name']); ?></td>
                    <td><?php echo htmlspecialchars($order['price']); ?></td>
                    <td><?php echo htmlspecialchars($order['status']); ?></td>
                    <td><?php echo htmlspecialchars($order['order_time']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="customer_dashboard.php">Back to Dashboard</a>
</body>
</html>
