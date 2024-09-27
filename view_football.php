<?php
// Include the database connection file
include 'dbinit.php';

// Fetch data from the 'footballs' table
$sql = "SELECT * FROM footballs";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Footballs</title>
</head>
<body>

<h2>Football Inventory</h2>

<?php
if ($result->num_rows > 0) {
    // Start an HTML table to display the footballs
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Name</th><th>Description</th><th>Quantity</th><th>Price</th><th>Brand</th></tr>";
    
    // Loop through each row of the result
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["FootballID"] . "</td>";
        echo "<td>" . $row["FootballName"] . "</td>";
        echo "<td>" . $row["Description"] . "</td>";
        echo "<td>" . $row["Quantity"] . "</td>";
        echo "<td>" . $row["Price"] . "</td>";
        echo "<td>" . $row["Brand"] . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
} else {
    // If no results are found
    echo "<p>No footballs found in the inventory.</p>";
}

// Close the database connection
$conn->close();
?>

</body>
</html>