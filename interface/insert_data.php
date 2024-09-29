<?php

// This below line is including the file that initializes the database connection.
include('../Models/dbinit.php');

// Initializing variables for form values and error messages.
$name = '';
$description = '';
$quantity = '';
$price = '';
$success = false;
$error = '';

// This below is an array to store field-specific error messages.
$fieldErrors = [
    'name' => '',
    'description' => '',
    'quantity' => '',
    'price' => ''
];

// This below if block checks if the form is submitted via POST method.
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    // Collecting form inputs.
    $name = $_POST['Football_JerseyName'];
    $description = $_POST['Football_JerseyDescription'];
    $quantity = $_POST['QuantityAvailable'];
    $price = $_POST['Price'];

    // This below if statements are validating inputs and handling errors.
    if (empty($name)) {
        $fieldErrors['name'] = "Jersey Name is required.";
    }
    if (empty($description)) {
        $fieldErrors['description'] = "Description is required.";
    }
    if (empty($quantity) || !is_numeric($quantity) || $quantity <= 0) {
        $fieldErrors['quantity'] = "Quantity is required and must be a positive number.";
    }
    if (empty($price) || !is_numeric($price) || $price <= 0) {
        $fieldErrors['price'] = "Price is required and must be a positive number.";
    }

    // If there are no errors in the form fields, it will proceed to insert data.
    if (array_filter($fieldErrors) == []) 
    {
        // This below prepare statment is a SQL statement to insert the form data into the database.
        $stmt = mysqli_prepare($dbc, "INSERT INTO football_jerseys (Football_JerseyName, Football_JerseyDescription, QuantityAvailable, Price, ProductAddedBy) VALUES (?, ?, ?, ?, 'Sarthak')");
        mysqli_stmt_bind_param($stmt, 'ssid', $name, $description, $quantity, $price);

        // Executing and checking if the statement was successful.
        if (mysqli_stmt_execute($stmt)) 
        {
            // If the statement is successfull, it redirects to index.php
            $success = true;
            header("Location: index.php");
            exit();
        } 
        else 
        {
            // This below line will display any SQL errors.
            $error = 'Error: ' . mysqli_error($dbc);
        }
    } 
    else 
    {
        // This below line will concatenate all field error messages to display at the top.
        $error = "Please fix the following errors:";
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
    <title>Add New Jersey</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../public/CSS/style.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-4">Add New Football Jersey</h1>
        <!-- This is an if else-if block for success or error message. -->
        <?php if ($success): ?>
            <div class="alert alert-success">Jersey added successfully!</div>
        <?php elseif (!empty($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <!-- This below form will only display if the jerseys or data exists in the Database. -->
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
                <input type="number" name="Price" class="form-control" step="0.01" value="<?= htmlspecialchars($price) ?>">
                <span class="text-danger"><?= $fieldErrors['price'] ?></span>
            </div>
            <button type="submit" class="btn btn-primary">Add Jersey</button>
            <a href="index.php" class="btn btn-success">Go back to Home</a>
        </form>
    </div>
</body>
</html>
