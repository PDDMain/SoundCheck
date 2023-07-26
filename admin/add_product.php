<?php
// Start the session to check if admin is logged in
session_start();

// Check if the admin is not logged in, redirect to the login page
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit;
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize the inputs (you can add more validation as needed)
    $name = $_POST['name'];
    $description = $_POST['description'];
    $image_link = $_POST['image_link'];
    $price = $_POST['price'];
    $category = $_POST['brand'];
    $color = $_POST['color'];
    $type = $_POST['category'];

    // Change this to your connection info.
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'admin';
    $DATABASE_PASS = '0f4828da8bb2c1de5036206c7bab79319c3ba671516ca6fe';
    $DATABASE_NAME = 'example';

    // Create a connection to the database
    $mysqli = new mysqli($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

    // Check for connection errors
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli->connect_error;
        exit();
    }

    // Prepare the SQL query to insert the new product into the database
    $sql = "INSERT INTO goods (id, name, description, image_link, price, category, color, type) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)";
    if ($stmt = $mysqli->prepare($sql)) {
        // Bind parameters to the prepared statement
        $stmt->bind_param('sssssss', $name, $description, $image_link, $price, $category, $color, $type);
        $stmt->execute();

        // Check if the product was added successfully
        if ($stmt->affected_rows === 1) {
            // Product added successfully, redirect to the admin dashboard or product list page
            header('Location: admin_dashboard.php');
            exit;
        } else {
            // Failed to add the product
            echo "Failed to add the product.";
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        // Error in the prepared statement
        echo "An error occurred. Please try again later.";
    }

    // Close the database connection
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Product</title>
    <link rel="stylesheet" href="css/header.css"></head>
    <link rel="stylesheet" href="css/add_product.css"></head>
<body>
<header>
    <div><a href="../main.php"><img class="logo" src="../img/logo.jpg"></a></div>
    <h2>Admin Panel</h2>
    <nav>
        <ul>
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="view_users.php">View Users</a></li>
            <li><a href="add_product.php">Add product</a></li>
            <li><a href="admin_logout.php">Logout</a></li>
        </ul>
    </nav>
</header>
<div class="gap"></div>
<div></div>

<div class="product-form">
    <h2>Add New Product</h2>
    <form action="add_product.php" method="post">
        <label for="name">Product Name:</label>
        <input type="text" name="name" id="name" required>
        <label for="description">Product Description:</label>
        <textarea name="description" id="description" rows="4"></textarea>
        <label for="image_link">Image Link:</label>
        <input type="text" name="image_link" id="image_link" required>
        <label for="price">Price:</label>
        <input type="text" name="price" id="price" required>
        <label for="category">Category:</label>
        <select name="category" id="category">
            <option value="in-ear">In-Ear</option>
            <option value="over-ear">Over-Ear</option>
            <option value="wireless">Wireless</option>
        </select>
        <label for="brand">Brand:</label>
        <select name="brand" id="brand">
            <option value="Apple">Apple</option>
            <option value="Samsung">Samsung</option>
            <option value="JVC">JVC</option>
            <option value="MEZE">MEZE</option>
        </select>
        <label for="brand">Color:</label>
        <select name="color" id="color">
            <option value="Black">Black</option>
            <option value="White">White</option>
            <option value="Red">Red</option>
        </select>
        <input type="submit" value="Add Product">
    </form>
</div>

</body>
</html>
