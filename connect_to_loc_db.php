<?php
// Replace with your database credentials
$hostname = 'db'; // Database host
$username = 'root'; // Database username
$password = 'password'; // Database password
$database = 'sql11644717'; // Database name

// Create a database connection
$conn = new mysqli($hostname, $username, $password, $database);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
