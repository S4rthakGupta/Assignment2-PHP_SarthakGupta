<?php
include('dbinit.php');

// Fetch football jerseys
$query = "SELECT * FROM football_jerseys";
$result = mysqli_query($dbc, $query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Football Jerseys Admin</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-4">Football Jerseys</h1>
        <a href="create.php" class="btn btn-primary mb-3">Add New Jersey</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= $row['Football_JerseyID'] ?></td>
                        <td><?= htmlspecialchars($row['Football_JerseyName']) ?></td>
                        <td><?= htmlspecialchars($row['Description']) ?></td>
                        <td><?= $row['QuantityAvailable'] ?></td>
                        <td><?= $row['Price'] ?></td>
                        <td>
                            <a href="update_data.php?id=<?= $row['Football_JerseyID'] ?>" class="btn btn-warning">Update</a>
                            <a href="delete_data.php?id=<?= $row['Football_JerseyID'] ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>