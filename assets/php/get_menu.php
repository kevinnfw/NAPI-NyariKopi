<?php
header('Content-Type: application/json');
include 'db_connection.php';

$sql = "SELECT id, name, price, image_url FROM menu";
$result = $conn->query($sql);

$menu = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $menu[] = $row;
    }
}

echo json_encode($menu);
$conn->close();
?>
