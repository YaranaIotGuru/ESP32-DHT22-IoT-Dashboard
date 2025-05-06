<?php
// Include config file
require 'config.php';

// Check if values are coming from ESP32
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $temperature = isset($_POST['temperature']) ? $_POST['temperature'] : null;
    $humidity = isset($_POST['humidity']) ? $_POST['humidity'] : null;

    if ($temperature !== null && $humidity !== null) {
        $sql = "INSERT INTO sensor_data (temperature, humidity, created_at) VALUES (?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("dd", $temperature, $humidity);

        if ($stmt->execute()) {
            echo "Data inserted successfully";
        } else {
            echo "Insert failed: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Temperature or humidity not provided";
    }
} else {
    echo "Invalid request method";
}

$conn->close();
?>
