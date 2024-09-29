<?php

// This below line is including the file that initializes the database connection.
include('../Models/dbinit.php');

// This below query fetches all the data from the football_jerseys table from the database.
$query = "SELECT * FROM football_jerseys";
$result = mysqli_query($dbc, $query);

// This below line will check if there are any rows in the result set.
if (mysqli_num_rows($result) > 0) 
{
    $hasRecords = true;
} 
else 
{
    $hasRecords = false;
}

// Closing the DataBase connection.
$dbc->close();
?>

<!-- HTML Starts here. -->
<!DOCTYPE html>
<html>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Jersey Data | Jersey Store</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="../public/CSS/style.css">

<body>
    <!-- This is the banner section. -->
    <div class="banner">
        <img src="../public/Images/Banner-img.jpg" alt="Football Jerseys Banner">
    </div>

    <!-- This is where the main content starts here. -->
    <div class="container content-section">

        <!-- This below is a button which when clicked goes to the insert_data.php and user can fill the form and add the data. -->
        <div class="text-center">
            <a href="insert_data.php" class="btn btn-primary add-btn">Add New Jersey</a>
        </div>

        <!-- Table of all the records -->
        <?php if ($hasRecords): ?>
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Product Added By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- This is all the data inside the table which will be fetched from the database. -->
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $row['Football_JerseyID'] ?></td>

                            <!-- Using Escape Special Characters for preventing any XSS attacks. -->
                            <td><?= htmlspecialchars($row['Football_JerseyName']) ?></td>
                            <td><?= htmlspecialchars($row['Football_JerseyDescription']) ?></td>
                            <td><?= $row['QuantityAvailable'] ?></td>
                            <td>$<?= number_format($row['Price'], 2) ?></td>
                            <td><?= htmlspecialchars($row['ProductAddedBy']) ?></td>

                            <!-- This below are two buttons for redirecting to update_data or delete_data.php -->
                            <td>
                                <a href="update_data.php?id=<?= $row['Football_JerseyID'] ?>" class="btn btn-warning">Update</a>
                                <a href="delete_data.php?id=<?= $row['Football_JerseyID'] ?>" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <!-- It will display this message if no records are found. Once the user adds the tables, then it will display the data and the table. -->
            <div class="alert alert-warning text-center" role="alert">
                No records found.
            </div>
        <?php endif; ?>
    </div>

    <!-- This is a basic footer only for index.php -->
    <footer class="bg-dark text-white text-center">
        <div class="container">
            <p>&copy; Copyright 2024 | Football Store</p>
            <p>Website developed by: Sarthak Gupta | Student ID: 8971797</p>
            <p>Subject: PHP Programming with MySQL</p>
        </div>
    </footer>
</body>

</html>