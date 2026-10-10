
<?php
include("db_connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $driver_id = $_POST['driver_id'];
    $location_status = 1;

    $sql = "UPDATE drivers SET location_active = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $location_status, $driver_id);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Location activated"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to activate location"]);
    }

    $stmt->close();
    $conn->close();
}
?>
