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

    // Change this to your connection info.
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'your_admin_username';
    $DATABASE_PASS = 'your_admin_password';
    $DATABASE_NAME = 'your_database_name';

    // Create a connection to the database
    $mysqli = new mysqli($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

    // Check for connection errors
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli->connect_error;
        exit();
    }

    // Prepare the SQL query to insert the new product into the database
    $sql = "INSERT INTO goods (name, description, image_link) VALUES (?, ?, ?)";
    if ($stmt = $mysqli->prepare($sql)) {
        // Bind parameters to the prepared statement
        $stmt->bind_param('sss', $name, $description, $image_link);
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
<!--    <link rel="stylesheet" href="../css/header.css"></head>-->
    <link rel="stylesheet" href="css/add_product.css"></head>
<body>
<header>
    <h1>Admin Dashboard - Add New Product</h1>
    <a href="admin_dashboard.php">Back to Dashboard</a>
    <a href="admin_logout.php">Logout</a>
</header>

<div class="product-form">
    <h2>Add New Product</h2>
    <form action="add_product.php" method="post">
        <label for="name">Product Name:</label>
        <input type="text" name="name" id="name" required>
        <label for="description">Product Description:</label>
        <textarea name="description" id="description" rows="4" required></textarea>
        <label for="image_link">Image Link:</label>
        <input type="text" name="image_link" id="image_link" required>
        <label for="price">Price:</label>
            <input type="text" name="price" id="price" required>
        <input type="submit" value="Add Product">
    </form>
</div>

<footer>
    <p>&copy; <?php echo date('Y'); ?> All rights reserved.</p>
</footer>
</body>
</html>
