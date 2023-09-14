<?php
// Replace with your database credentials
$hostname = 'sql11.freemysqlhosting.net:3306'; // Database host
$username = 'sql11644717'; // Database username
$password = 'ZmwJ9MMkZd'; // Database password
$database = 'sql11644717'; // Database name

// Create a database connection
$conn = new mysqli($hostname, $username, $password, $database);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
