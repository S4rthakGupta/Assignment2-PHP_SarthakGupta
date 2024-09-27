<?php
// Initialize variables
$name = $description = $quantity = $price = $brand = "";
$nameErr = $descriptionErr = $quantityErr = $priceErr = $brandErr = "";

// Handle POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $valid = true;

    // Validate Name
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
        $valid = false;
    } else {
        $name = test_input($_POST["name"]);
    }

    // Validate Description
    if (empty($_POST["description"])) {
        $descriptionErr = "Description is required";
        $valid = false;
    } else {
        $description = test_input($_POST["description"]);
    }

    // Validate Quantity
    if (empty($_POST["quantity"])) {
        $quantityErr = "Quantity is required";
        $valid = false;
    } elseif (!is_numeric($_POST["quantity"])) {
        $quantityErr = "Quantity must be a number";
        $valid = false;
    } else {
        $quantity = test_input($_POST["quantity"]);
    }

    // Validate Price
    if (empty($_POST["price"])) {
        $priceErr = "Price is required";
        $valid = false;
    } elseif (!is_numeric($_POST["price"])) {
        $priceErr = "Price must be a number";
        $valid = false;
    } else {
        $price = test_input($_POST["price"]);
    }

    // Validate Brand
    if (empty($_POST["brand"])) {
        $brandErr = "Brand is required";
        $valid = false;
    } else {
        $brand = test_input($_POST["brand"]);
    }

    // If valid, insert into the database
    if ($valid) {
        include 'dbinit.php'; // Use the dbinit.php for connection

        $stmt = $conn->prepare("INSERT INTO footballs (FootballName, Description, Quantity, Price, ProductAddedBy, Brand) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiiss", $name, $description, $quantity, $price, $productAddedBy, $brand);

        $productAddedBy = "YourName"; // Hardcoded value for the ProductAddedBy field
        if ($stmt->execute()) {
            echo "Football added successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
}

// Input sanitization
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Football</title>
</head>
<body>
    <h2>Add New Football</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        Football Name: <input type="text" name="name" value="<?php echo $name;?>">
        <span><?php echo $nameErr;?></span><br><br>

        Description: <textarea name="description"><?php echo $description;?></textarea>
        <span><?php echo $descriptionErr;?></span><br><br>

        Quantity: <input type="text" name="quantity" value="<?php echo $quantity;?>">
        <span><?php echo $quantityErr;?></span><br><br>

        Price: <input type="text" name="price" value="<?php echo $price;?>">
        <span><?php echo $priceErr;?></span><br><br>

        Brand: <input type="text" name="brand" value="<?php echo $brand;?>">
        <span><?php echo $brandErr;?></span><br><br>

        <input type="submit" value="Add Football">
    </form>
</body>
</html>