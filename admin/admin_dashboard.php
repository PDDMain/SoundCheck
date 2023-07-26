<?php
// Start the session to check if admin is logged in
session_start();

// Check if the admin is not logged in, redirect to the login page
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/admin_dashboard.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
<header>
    <div><a href="../main.php"><img class="logo" src="../img/logo.jpg"></a></div>
    <h2>Admin Panel</h2>
    <nav>
        <ul>
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="admin_logout.php">Logout</a></li>
        </ul>
    </nav>
</header>
<div class="gap"></div>
<div></div>
<main>
    <div class="dashboard-content">
        <!-- Add the dashboard content here -->
        <!-- Add links or buttons for managing users and products -->
        <ul>
            <li><a href="view_users.php">View Users</a></li>
            <li><a href="view_products.php">View Products</a></li>
            <li><a href="add_product.php">Add New Product</a></li>
            <li><a href="view_reviews.php">View Reviews</a></li>

            <!-- Add more links/buttons for other admin functionalities -->
        </ul>
    </div>
</main>
</body>
</html>
