<?php
include('../Models/dbinit.php');

// Initialize variables
$id = $_GET['id'] ?? null;
$jersey = null;
$success = false;
$error = '';

if ($id) {
    // Fetch the jersey by ID
    $query = "SELECT * FROM football_jerseys WHERE Football_JerseyID = ?";
    $stmt = mysqli_prepare($dbc, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $jersey = mysqli_fetch_assoc($result);

    // Handle the case where no jersey was found
    if (!$jersey) {
        $error = "Football Jersey not found.";
    }
}

// Initialize form values
$name = $jersey['Football_JerseyName'] ?? '';
$description = $jersey['Description'] ?? '';
$quantity = $jersey['QuantityAvailable'] ?? '';
$price = $jersey['Price'] ?? '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['Football_JerseyName']);
    $description = trim($_POST['Description']);
    $quantity = trim($_POST['QuantityAvailable']);
    $price = trim($_POST['Price']);

    // Validate and sanitize inputs
    if (!empty($name) && !empty($description) && !empty($quantity) && !empty($price)) {
        // Ensure that quantity and price are valid numbers and greater than 0
        if (!is_numeric($quantity) || !is_numeric($price) || intval($quantity) <= 0 || floatval($price) <= 0) {
            $error = "Quantity and Price must be positive numbers.";
        } else {
            // Update the jersey details
            $stmt = mysqli_prepare($dbc, "UPDATE football_jerseys SET Football_JerseyName = ?, Description = ?, QuantityAvailable = ?, Price = ? WHERE Football_JerseyID = ?");
            mysqli_stmt_bind_param($stmt, 'ssidi', $name, $description, $quantity, $price, $id);

            if (mysqli_stmt_execute($stmt)) {
                $success = true;
                header("Location: index.php"); // Redirect to index.php
                exit(); // Ensure script stops after redirection
            } else {
                $error = 'Error updating jersey: ' . mysqli_error($dbc);
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
    <title>Update Football Jersey</title>
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
        <h1 class="mt-4">Update Football Jersey</h1>
        <?php if ($success): ?>
            <div class="alert alert-success">Jersey updated successfully!</div>
        <?php elseif (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <div id="validationErrors" class="error"></div> <!-- For client-side validation errors -->
        
        <!-- Only show form if jersey exists -->
        <?php if ($jersey): ?>
        <form name="jerseyForm" method="POST" action="" onsubmit="return validateForm()">
            <div class="form-group">
                <label>Jersey Name<span class="required-asterisk">*</span></label>
                <input type="text" name="Football_JerseyName" class="form-control" value="<?= htmlspecialchars($name) ?>" >
            </div>
            <div class="form-group">
                <label>Description<span class="required-asterisk">*</span></label>
                <textarea name="Description" class="form-control"><?= htmlspecialchars($description) ?></textarea>
            </div>
            <div class="form-group">
                <label>Quantity Available<span class="required-asterisk">*</span></label>
                <input type="number" name="QuantityAvailable" class="form-control" value="<?= htmlspecialchars($quantity) ?>" >
            </div>
            <div class="form-group">
                <label>Price<span class="required-asterisk">*</span></label>
                <input type="number" step="0.01" name="Price" class="form-control" value="<?= htmlspecialchars($price) ?>" >
            </div>
            <button type="submit" class="btn btn-warning">Update Jersey</button>
        </form>
        <?php endif; ?>
    </div>
</body>
</html>
