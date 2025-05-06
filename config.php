<?php
// Database credentials
$servername = "localhost"; // MySQL server name
$username = "your_database_username"; // MySQL username
$password = "your_database_password"; // MySQL password
$dbname = "your_database_name"; // MySQL database name

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
