<?php
$logFile = __DIR__ . '/debug_log.txt'; // Pastikan path valid
file_put_contents($logFile, "=== New Request ===\n", FILE_APPEND);

include 'db_connection.php';
file_put_contents($logFile, "Database connection loaded\n", FILE_APPEND);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sender_id = filter_input(INPUT_POST, 'sender_id', FILTER_VALIDATE_INT);
    $message = trim(filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING));

    file_put_contents($logFile, "Received Data: sender_id=$sender_id, message=$message\n", FILE_APPEND);

    if ($sender_id && $message) {
        $stmt = $conn->prepare("INSERT INTO messages (sender_id, message) VALUES (?, ?)");
        if ($stmt) {
            $stmt->bind_param("is", $sender_id, $message);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                file_put_contents($logFile, "Message inserted successfully\n", FILE_APPEND);
                echo json_encode(["status" => "success", "message" => "Message sent successfully."]);
            } else {
                file_put_contents($logFile, "Insert failed: " . $stmt->error . "\n", FILE_APPEND);
                echo json_encode(["status" => "error", "message" => "Failed to save the message."]);
            }
            $stmt->close();
        } else {
            file_put_contents($logFile, "SQL preparation failed: " . $conn->error . "\n", FILE_APPEND);
            echo json_encode(["status" => "error", "message" => "Database error: " . $conn->error]);
        }
    } else {
        file_put_contents($logFile, "Invalid input: sender_id=$sender_id, message=$message\n", FILE_APPEND);
        echo json_encode(["status" => "error", "message" => "Invalid input. Both sender_id and message are required."]);
    }
} else {
    file_put_contents($logFile, "Invalid request method\n", FILE_APPEND);
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
$conn->close();
?>
