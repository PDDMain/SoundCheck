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
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="css/admin_dashboard.css">
</head>
<body>
<header>
    <a href="admin_logout.php">Logout</a>
</header>
<header>
    <div><a href="../main.php"><img class="logo" src="../img/logo.jpg"></a></div>
    <h2>Admin Dashboard</h2>
    <nav>
        <ul>
            <li><a href="view_users.php">View Users</a></li>
            <li><a href="add_product.php">Add New Product</a></li>
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
            <li><a href="add_product.php">Add New Product</a></li>
            <!-- Add more links/buttons for other admin functionalities -->
        </ul>
    </div>
</main>
<footer class="footer">
    <!-- Footer content goes here -->
    <p>&copy; 2023 All rights reserved.</p>
</footer>
</body>
</html>
