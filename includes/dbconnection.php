<?php 
// Database connection settings
define('DB_HOST', 'localhost'); // Database server address
define('DB_USER', 'root');      // Database username
define('DB_PASS', '');          // Database password
define('DB_NAME', 'sales_db');  // Database name

// Try to establish a database connection using PDO
try {
    // Create a new PDO instance
    $dbh = new PDO(
        "mysql:host=".DB_HOST.";dbname=".DB_NAME, // DSN (Data Source Name)
        DB_USER, // Username
        DB_PASS, // Password
        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'") // Ensure UTF-8 encoding
    );
} catch (PDOException $e) {
    // If an error occurs, stop the script and display the error message
    exit("Error: " . $e->getMessage());
}
?>
