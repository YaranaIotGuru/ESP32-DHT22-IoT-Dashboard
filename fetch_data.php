<?php
// Database connection
require_once 'config.php';

// Error handling for database connection
if (!$conn) {
    http_response_code(500);
    die(json_encode(['error' => 'Database connection failed: ' . mysqli_connect_error()]));
}

// Set limit to match UI's maxDataPoints (20)
$limit = 20;

// Query to fetch the latest 20 records
$query = "SELECT id, temperature, humidity, created_at 
          FROM sensor_data 
          ORDER BY created_at DESC 
          LIMIT ?";
$stmt = mysqli_prepare($conn, $query);

if (!$stmt) {
    http_response_code(500);
    die(json_encode(['error' => 'Query preparation failed: ' . mysqli_error($conn)]));
}

// Bind the limit parameter
mysqli_stmt_bind_param($stmt, "i", $limit);

// Execute the query
if (!mysqli_stmt_execute($stmt)) {
    http_response_code(500);
    die(json_encode(['error' => 'Query execution failed: ' . mysqli_error($conn)]));
}

// Get the result
$result = mysqli_stmt_get_result($stmt);

$data = [];

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = [
            'id' => $row['id'],
            'temperature' => floatval($row['temperature']),
            'humidity' => floatval($row['humidity']),
            'created_at' => date('Y-m-d H:i:s', strtotime($row['created_at'])) // Standardize timestamp format
        ];
    }
} else {
    // Return empty array if no data
    $data = [];
}

// Close statement and connection
mysqli_stmt_close($stmt);
mysqli_close($conn);

// Set JSON header and output data
header('Content-Type: application/json');
echo json_encode($data);
?>