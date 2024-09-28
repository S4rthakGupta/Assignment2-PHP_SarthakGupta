<?php
include('../Models/dbinit.php');

// Initialize variables for form values
$name = '';
$description = '';
$quantity = '';
$price = '';
$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['Football_JerseyName'];
    $description = $_POST['Description'];
    $quantity = $_POST['QuantityAvailable'];
    $price = $_POST['Price'];

    // Validate and sanitize inputs
    if (!empty($name) && !empty($description) && !empty($quantity) && !empty($price)) {
        if (!is_numeric($quantity) || !is_numeric($price) || $quantity <= 0 || $price <= 0) {
            $error = "Quantity and Price must be positive numbers.";
        } else {
            $stmt = mysqli_prepare($dbc, "INSERT INTO football_jerseys (Football_JerseyName, Description, QuantityAvailable, Price, ProductAddedBy) VALUES (?, ?, ?, ?, 'Sarthak')");
            mysqli_stmt_bind_param($stmt, 'ssdi', $name, $description, $quantity, $price);

            if (mysqli_stmt_execute($stmt)) {
                $success = true;
                header("Location: index.php"); // Redirect to index.php
                exit(); // Ensure script stops after redirection
            } else {
                $error = 'Error: ' . mysqli_error($dbc);
            }
        }
    } else {
        $error = "All fields are required.";
    }
}

// Close the connection
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

    <script>
        function validateForm() {
            let name = document.forms["jerseyForm"]["Football_JerseyName"].value;
            let description = document.forms["jerseyForm"]["Description"].value;
            let quantity = document.forms["jerseyForm"]["QuantityAvailable"].value;
            let price = document.forms["jerseyForm"]["Price"].value;
            let errorMessages = [];

            if (name === "") {
                errorMessages.push("Jersey Name is required.");
            }
            if (description === "") {
                errorMessages.push("Description is required.");
            }
            if (quantity === "" || isNaN(quantity) || parseInt(quantity) <= 0) {
                errorMessages.push("Quantity must be a positive number.");
            }
            if (price === "" || isNaN(price) || parseFloat(price) <= 0) {
                errorMessages.push("Price must be a positive number.");
            }

            if (errorMessages.length > 0) {
                document.getElementById("validationErrors").innerHTML = "<ul><li>" + errorMessages.join("</li><li>") + "</li></ul>";
                return false;
            }
            return true;
        }
    </script>
</head>

<body>
    <div class="container">
        <h1 class="mt-4">Add New Football Jersey</h1>
        <?php if ($success): ?>
            <div class="alert alert-success">Jersey added successfully!</div>
        <?php elseif (!empty($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <div id="validationErrors" class="error"></div> <!-- For client-side validation errors -->

        <form name="jerseyForm" method="POST" action="" onsubmit="return validateForm()">
            <div class="form-group">
                <label>Jersey Name<span class="required-asterisk">*</span></label>
                <input type="text" name="Football_JerseyName" class="form-control" value="<?= htmlspecialchars($name) ?>">
            </div>
            <div class="form-group">
                <label>Description<span class="required-asterisk">*</span></label>
                <textarea name="Description" class="form-control"><?= htmlspecialchars($description) ?></textarea>
            </div>
            <div class="form-group">
                <label>Quantity Available<span class="required-asterisk">*</span></label>
                <input type="number" name="QuantityAvailable" class="form-control" value="<?= htmlspecialchars($quantity) ?>">
            </div>
            <div class="form-group">
                <label>Price<span class="required-asterisk">*</span></label>
                <input type="number" name="Price" class="form-control" step="0.01" value="<?= htmlspecialchars($price) ?>">
            </div>
            <button type="submit" class="btn btn-primary">Add Jersey</button>
        </form>
    </div>
</body>

</html>