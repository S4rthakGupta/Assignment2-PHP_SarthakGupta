<?php
// Define constants for database connection parameters
define('DB_SERVER', 'localhost'); // Change if necessary
define('DB_USERNAME', 'root'); // Change to your database username
define('DB_PASSWORD', ''); // Change to your database password
define('DB_NAME', 'football_jerseys'); // Database name
 
// Create connection
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD);
 
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
 
// Create database
$sql = "CREATE DATABASE IF NOT EXISTS " . DB_NAME;
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully\n";
} else {
    echo "Error creating database: " . $conn->error;
}
 
// Select the database
$conn->select_db(DB_NAME);

// Create football_jerseys table
$query = "CREATE TABLE IF NOT EXISTS football_jerseys (
    Football_JerseyID INT AUTO_INCREMENT PRIMARY KEY,
    Football_JerseyName VARCHAR(100) NOT NULL,
    Description TEXT NOT NULL,
    QuantityAvailable INT NOT NULL,
    Price DECIMAL(10, 2) NOT NULL,
    ProductAddedBy VARCHAR(100) NOT NULL DEFAULT 'Sarthak'
)";


if ($conn->query($sql) === TRUE) {
    echo "Table 'beds' created successfully\n";
} else {
    echo "Error creating table: " . $conn->error;
}
 
// Close the connection
$conn->close();
?>