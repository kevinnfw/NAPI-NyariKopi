
<?php
include("db_connection.php");

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $sql = "SELECT * FROM restock_items";
    $result = $conn->query($sql);

    $items = [];
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }

    echo json_encode($items);

    $conn->close();
}
?>
