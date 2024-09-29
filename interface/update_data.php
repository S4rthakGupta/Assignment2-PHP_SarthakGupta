<?php

// This below line is including the file that initializes the database connection.
include('../Models/dbinit.php');

// Initializing Key Variables.
$id = $_GET['id'] ?? null;
$jersey = null;
$success = false;
$error = '';

// Array to store field-specific error messages.
$fieldErrors = [
    'name' => '',
    'description' => '',
    'quantity' => '',
    'price' => '',
    'size' => ''
];

if ($id) {
    // Fetching the jersey by ID.
    $query = "SELECT * FROM football_jerseys WHERE Football_JerseyID = ?";

    // This below line will prepare the SQL Query.
    $stmt = mysqli_prepare($dbc, $query);

    // Binding the Jersey ID to query.
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $jersey = mysqli_fetch_assoc($result);

    // This will handle the case where no jersey is found.
    if (!$jersey) {
        $error = "Football Jersey not found.";
    }
}

// Initializing form values and setting default values based on the jersey details.
$name = $jersey['Football_JerseyName'] ?? '';
$description = $jersey['Football_JerseyDescription'] ?? '';
$quantity = $jersey['QuantityAvailable'] ?? '';
$price = $jersey['Price'] ?? '';
$size = $jersey['Size'] ?? '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{

    // These below line will get the form input values.
    $name = trim($_POST['Football_JerseyName']);
    $description = trim($_POST['Football_JerseyDescription']);
    $quantity = trim($_POST['QuantityAvailable']);
    $price = trim($_POST['Price']);
    $size = trim($_POST['Size']);

    // This below if statements will validate and sanitize inputs.
    if (empty($name)) 
    {
        $fieldErrors['name'] = "Jersey Name is required.";
    }
    if (empty($description)) 
    {
        $fieldErrors['description'] = "Description is required.";
    }
    if (empty($quantity) || !is_numeric($quantity) || intval($quantity) <= 0) 
    {
        $fieldErrors['quantity'] = "Quantity is required and must be a positive number.";
    }
    if (empty($price) || !is_numeric($price) || floatval($price) <= 0) 
    {
        $fieldErrors['price'] = "Price is required and must be a positive number.";
    }
    if (empty($description)) 
    {
        $fieldErrors['size'] = "Product size is required.";
    }

    // If there are no errors this below code will update the jersey details.
    if (array_filter($fieldErrors) == []) 
    {
        // This below line prepares the update query.
        $stmt = mysqli_prepare($dbc, "UPDATE football_jerseys SET Football_JerseyName = ?, Football_JerseyDescription = ?, QuantityAvailable = ?, Price = ?, Size = ? WHERE Football_JerseyID = ?");

        // Binding the input values to the query.
        mysqli_stmt_bind_param($stmt, 'ssidsi', $name, $description, $quantity, $price, $size,$id);

        // Executing the query and checking if it was successfull.
        if (mysqli_stmt_execute($stmt)) {
            // If the query gets successfull, it redirects the user to index.php
            $success = true;
            header("Location: index.php");
            exit();
        } 
        else 
        {
            // This will set an error message if the query fails.
            $error = 'Error updating jersey: ' . mysqli_error($dbc);
        }
    } 
    else 
    {
        // This sets a general error if the validation fails.
        $error = "Please fix the following errors.";
    }
}

// Closing the DataBase connection.
$dbc->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Football Jersey</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../public/CSS/style.css">
</head>

<body>
    <div class="container">
        <h1 class="mt-4">Update Football Jersey</h1>

        <!-- This below is and if else-if block for success or error message -->
        <?php if ($success): ?>
            <div class="alert alert-success">Jersey updated successfully!</div>
        <?php elseif (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <!-- This if statement will only show form if jersey exists in the database. -->
        <?php if ($jersey): ?>
            <form name="jerseyForm" method="POST" action="">
                <div class="form-group">
                    <label>Jersey Name<span class="required-asterisk">*</span></label>
                    <input type="text" name="Football_JerseyName" class="form-control" value="<?= htmlspecialchars($name) ?>">
                    <span class="text-danger"><?= $fieldErrors['name'] ?></span>
                </div>
                <div class="form-group">
                    <label>Description<span class="required-asterisk">*</span></label>
                    <textarea name="Football_JerseyDescription" class="form-control"><?= htmlspecialchars($description) ?></textarea>
                    <span class="text-danger"><?= $fieldErrors['description'] ?></span>
                </div>
                <div class="form-group">
                    <label>Quantity Available<span class="required-asterisk">*</span></label>
                    <input type="number" name="QuantityAvailable" class="form-control" value="<?= htmlspecialchars($quantity) ?>">
                    <span class="text-danger"><?= $fieldErrors['quantity'] ?></span>
                </div>
                <div class="form-group">
                    <label>Price<span class="required-asterisk">*</span></label>
                    <input type="number" step="0.01" name="Price" class="form-control" value="<?= htmlspecialchars($price) ?>">
                    <span class="text-danger"><?= $fieldErrors['price'] ?></span>
                </div>

                <!-- Custom Field as per my choice. -->
                <div class="form-group">
                    <label>Size<span class="required-asterisk">*</span></label>
                    <input type="text" name="Size" class="form-control" value="<?= htmlspecialchars($size) ?>">
                    <span class="text-danger"><?= $fieldErrors['size'] ?></span>
                </div>
                <button type="submit" class="btn btn-warning">Update Jersey</button>
                <a href="index.php" class="btn btn-success">Go back to Home</a>
            </form>
        <?php endif; ?>
    </div>
</body>

</html>