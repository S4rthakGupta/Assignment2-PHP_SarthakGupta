<?php
include('../Models/dbinit.php');


$id = $_GET['id'] ?? null;
$success = false;
$error = '';

if ($id) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Delete the jersey
        $stmt = mysqli_prepare($dbc, "DELETE FROM football_jerseys WHERE Football_JerseyID = ?");
        mysqli_stmt_bind_param($stmt, 'i', $id);

        if (mysqli_stmt_execute($stmt)) {
            $success = true;
            header("Location: index.php"); // Redirect to index.php after deletion
            exit(); // Ensure the script stops after redirection
        } else {
            $error = 'Error: ' . mysqli_error($dbc);
        }
    }
}

// Close the connection
$dbc->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Football Jersey</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-4">Delete Football Jersey</h1>
        <?php if ($success): ?>
            <div class="alert alert-success">Jersey deleted successfully!</div>
        <?php elseif (!empty($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php else: ?>
            <div class="alert alert-warning">Are you sure you want to delete this jersey?</div>
            <form method="POST" action="">
                <button type="submit" class="btn btn-danger">Yes, Delete</button>
                <a href="index.php" class="btn btn-secondary">Cancel</a>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>