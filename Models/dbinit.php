<?php
// Database credentials
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_HOST', 'localhost');
define('DB_NAME', 'football_store');

// Connect to MySQL
$dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
    OR die('Could not connect to MySQL: ' . mysqli_connect_error());
mysqli_set_charset($dbc, 'utf8');

// Create football_jerseys table
$query = "CREATE TABLE IF NOT EXISTS football_jerseys (
    Football_JerseyID INT AUTO_INCREMENT PRIMARY KEY,
    Football_JerseyName VARCHAR(100) NOT NULL,
    Description TEXT NOT NULL,
    QuantityAvailable INT NOT NULL,
    Price DECIMAL(10, 2) NOT NULL,
    ProductAddedBy VARCHAR(100) NOT NULL DEFAULT 'Sarthak'
)";
mysqli_query($dbc, $query) or die('Error creating table: ' . mysqli_error($dbc));
?>