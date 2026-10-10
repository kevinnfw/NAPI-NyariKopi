<?php
session_start();

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'driver') {
    echo "<script>alert('Anda tidak memiliki akses ke halaman ini!'); window.location.href='../driver/driver_login.html';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Dashboard</title>
</head>
<body>
    <h1>Selamat Datang, Driver: <?php echo $_SESSION['username']; ?></h1>
    <!-- Konten dashboard driver -->
</body>
</html>
