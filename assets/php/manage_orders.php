
<?php
include("db_connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $order_id = $_POST['order_id'];
    $status = $_POST['status']; // Example: 'confirmed', 'completed'

    $sql = "UPDATE orders SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $status, $order_id);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Order status updated"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to update order status"]);
    }

    $stmt->close();
    $conn->close();
}
header('Content-Type: application/json');

$action = $_POST['action'] ?? '';

if ($action === 'mark_paid') {
    $order_id = intval($_POST['order_id'] ?? 0);

    if ($order_id > 0) {
        $stmt = $conn->prepare("UPDATE orders SET status = 'paid' WHERE id = ?");
        $stmt->bind_param("i", $order_id);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Order marked as paid."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to update order status."]);
        }

        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid order ID."]);
    }
} elseif ($action === 'get_paid_orders') {
    $result = $conn->query("SELECT id, order_details FROM orders WHERE status = 'paid'");

    if ($result) {
        $orders = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode(["status" => "success", "data" => $orders]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to fetch orders."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid action."]);
}

$conn->close();
?>
