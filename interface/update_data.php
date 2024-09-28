<?php
include('dbinit.php');

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
}

// Initialize variables for form values
$name = $jersey['Football_JerseyName'] ?? '';
$description = $jersey['Description'] ?? '';
$quantity = $jersey['QuantityAvailable'] ?? '';
$price = $jersey['Price'] ?? '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['Football_JerseyName'];
    $description = $_POST['Description'];
    $quantity = $_POST['QuantityAvailable'];
    $price = $_POST['Price'];

    // Validate and update
    if (!empty($name) && !empty($description) && !empty($quantity) && !empty($price)) {
        $stmt = mysqli_prepare($dbc, "UPDATE football_jerseys SET Football_JerseyName = ?, Description = ?, QuantityAvailable = ?, Price = ? WHERE Football_JerseyID = ?");
        mysqli_stmt_bind_param($stmt, 'ssiii', $name, $description, $quantity, $price, $id);

        if (mysqli_stmt_execute($stmt)) {
            $success = true;
        } else {
            $error = 'Error: ' . mysqli_error($dbc);
        }
    } else {
        $error = "All fields are required.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update Football Jersey</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-4">Update Football Jersey</h1>
        <?php if ($success): ?>
            <div class="alert alert-success">Jersey updated successfully!</div>
        <?php elseif (!empty($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label>Jersey Name</label>
                <input type="text" name="Football_JerseyName" class="form-control" value="<?= htmlspecialchars($name) ?>" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="Description" class="form-control" required><?= htmlspecialchars($description) ?></textarea>
            </div>
            <div class="form-group">
                <label>Quantity Available</label>
                <input type="number" name="QuantityAvailable" class="form-control" value="<?= htmlspecialchars($quantity) ?>" required>
            </div>
            <div class="form-group">
                <label>Price</label>
                <input type="number" step="0.01" name="Price" class="form-control" value="<?= htmlspecialchars($price) ?>" required>
            </div>
            <button type="submit" class="btn btn-warning">Update Jersey</button>
        </form>
    </div>
</body>
</html>