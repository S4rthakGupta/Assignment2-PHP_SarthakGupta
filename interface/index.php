<?php
include('../Models/dbinit.php');

// Fetch football jerseys
$query = "SELECT * FROM football_jerseys";
$result = mysqli_query($dbc, $query);

// Check if there are any rows in the result set
if(mysqli_num_rows($result) > 0) {
    $hasRecords = true;
} else {
    $hasRecords = false;
}

// Close the connection
$dbc->close();
?>

<!DOCTYPE html>
<html>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jersey Data | Jersey Store</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../public/CSS/style.css">
<body>
    <!-- Banner Section -->
    <div class="banner">
        <img src="../public/Images/Banner-img.jpg" alt="Football Jerseys Banner"> <!-- Replace with your banner image URL -->
    </div>

    <!-- Content Section -->
    <div class="container content-section">
        <!-- Button to Add New Jersey -->
        <div class="text-center">
            <a href="insert_data.php" class="btn btn-primary add-btn">Add New Jersey</a>
        </div>
        
        <!-- Table of Football Jerseys -->
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
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $row['Football_JerseyID'] ?></td>
                            <td><?= htmlspecialchars($row['Football_JerseyName']) ?></td>
                            <td><?= htmlspecialchars($row['Football_JerseyDescription']) ?></td>
                            <td><?= $row['QuantityAvailable'] ?></td>
                            <td>$<?= number_format($row['Price'], 2) ?></td>
                            <td><?= htmlspecialchars($row['ProductAddedBy']) ?></td>
                            <td>
                                <a href="update_data.php?id=<?= $row['Football_JerseyID'] ?>" class="btn btn-warning">Update</a>
                                <a href="delete_data.php?id=<?= $row['Football_JerseyID'] ?>" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-warning text-center" role="alert">
                No records found.
            </div>
        <?php endif; ?>
    </div>

    <!-- Footer Section -->
    <footer class="bg-dark text-white text-center">
        <div class="container">
            <p>&copy; Copyright 2024 | Football Store</p>
            <p>Website developed by: Sarthak Gupta | Student ID: 8971797</p>
            <p>Subject: PHP Programming with MySQL</p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
