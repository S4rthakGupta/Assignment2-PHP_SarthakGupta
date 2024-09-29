<?php
// This below line is including the file that initializes the database connection.
include('../Models/dbinit.php');


// Retrieve the jersey ID from the query string (GET request). If not provided, $id will be null.
$id = $_GET['id'] ?? null;

// These below line will initialize flags for tracking success and errors.
$success = false;
$error = '';

// If an ID is provided, a jersey is selected for deletion.
if ($id) 
{
    // This below if block checks if the form has been submitted via POST request or not.
    if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    {
        // This below code prepares a statement to delete the football jersey with the given ID.
        $stmt = mysqli_prepare($dbc, "DELETE FROM football_jerseys WHERE Football_JerseyID = ?");

        // Binding the jersey ID (integer) to the prepared statement.
        mysqli_stmt_bind_param($stmt, 'i', $id);


        // This below if block will execute the statement and check if the data is deleted or not.
        if (mysqli_stmt_execute($stmt)) 
        {
            // If it is successfully deleted then it redirects the user to index.php
            $success = true;
            header("Location: index.php");
            exit();
        } 
        else 
        {
            // It will come to this else block in case of any error and it will store it into "$error" variable.
            $error = 'Error: ' . mysqli_error($dbc);
        }
    }
}

// This below line will close the DataBase connection.
$dbc->close();
?>

<!-- HTML code starts here.  -->
<!DOCTYPE html>
<html>

<head>
    <title>Delete Football Jersey</title>
    <!-- Link of BootStrap. -->
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

            <!-- The below form starts here, with the POST method. Action is empty as this is a self-processing page -->
            <form method="POST" action="">
                <button type="submit" class="btn btn-danger">Yes, Delete</button>
                <a href="index.php" class="btn btn-secondary">Cancel</a>
            </form>
        <?php endif; ?>
    </div>
</body>

</html>