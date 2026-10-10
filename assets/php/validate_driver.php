
<?php
include("db_connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $driver_id = $_POST['driver_id'];

    $sql = "SELECT * FROM drivers WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $driver_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(["status" => "success", "message" => "Driver data validated"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Driver not found"]);
    }

    $stmt->close();
    $conn->close();
}
?>
