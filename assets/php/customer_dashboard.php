<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: customer_login.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        /* Masukkan CSS Dashboard Anda */
    </style>
</head>
<body>
    <div class="dashboard">
        <header class="dashboard-header">
            <h1>Halo, Selamat Datang <?php echo htmlspecialchars($_SESSION['username']); ?> di Coffee Monitoring!</h1>
        </header>
        <main class="dashboard-content">
            <div class="dashboard-card">
                <img src="../images/order-icon.png" alt="Order Coffee">
                <h2>Order Coffee</h2>
                <p>Choose your favorite coffee and place your order now!</p>
                <a href="order.html">Order Now</a>
            </div>
            <div class="dashboard-card">
                <img src="../images/history-icon.png" alt="Order History">
                <h2>Order History</h2>
                <p>Check your previous orders and track your coffee journey.</p>
                <a href="order_history.php">View History</a>
            </div>
            <div class="dashboard-card">
                <img src="../images/account-icon.png" alt="Account Settings">
                <h2>Account Settings</h2>
                <p>Manage your account details and preferences.</p>
                <a href="account_settings.html">Edit Account</a>
            </div>
        </main>
        <footer class="dashboard-footer">
            <p>&copy; 2025 CoffeeShop Online. All rights reserved. <a href="logout.php">Logout</a></p>
        </footer>
    </div>
</body>
</html>
