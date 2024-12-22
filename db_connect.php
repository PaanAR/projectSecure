<?php

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$database = "sales_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    // If there is an error, display a user-friendly message
    die("Connection failed: " . $conn->connect_error);
} 
?>

<!-- Error Handling: The code checks if there's an error during the connection using $conn->connect_error. If an error exists, it outputs a detailed error message.
Success Message: If the connection is successful, it echoes "Database connection successful!" -->