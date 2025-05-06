<?php
// Database credentials
$servername = "localhost"; // MySQL server name
$username = "u375768049_esp32test"; // MySQL username
$password = "Yarana@7052"; // MySQL password
$dbname = "u375768049_esp32test"; // MySQL database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    // Uncomment the below line for debugging connection success
    // echo "Database connected successfully!";
}
?>
