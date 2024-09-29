<?php
// Define constants for database connection parameters
define('DB_SERVER', 'localhost'); // Change if necessary
define('DB_USERNAME', 'root'); // Change to your database username
define('DB_PASSWORD', ''); // Change to your database password
define('DB_NAME', 'football_store'); // Database name

// Create connection
$dbc = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD);

// Check connection
if ($dbc->connect_error) {
    die("Connection failed: " . $dbc->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS " . DB_NAME;
if ($dbc->query($sql) === TRUE) {
    echo "<script>console.log('Database \"" . DB_NAME . "\" created successfully');</script>";
} else {
    echo "<script>console.log('Error creating database: " . $dbc->error . "');</script>";
}

// Select the database
$dbc->select_db(DB_NAME);

// Create football_jerseys table
$table_query = "CREATE TABLE IF NOT EXISTS football_jerseys (
    Football_JerseyID INT AUTO_INCREMENT PRIMARY KEY,
    Football_JerseyName VARCHAR(100) NOT NULL,
    Football_JerseyDescription TEXT NOT NULL,
    QuantityAvailable INT NOT NULL,
    Price DECIMAL(10, 2) NOT NULL,
    ProductAddedBy VARCHAR(100) NOT NULL DEFAULT 'Sarthak'
)";

// Execute the query to create the table
if ($dbc->query($table_query) === TRUE) {
    echo "<script>console.log('Table \"football_jerseys\" created successfully');</script>";
} else {
    echo "<script>console.log('Error creating table: " . $dbc->error . "');</script>";
}

?>