<?php
// Start the session to check if admin is logged in
session_start();

// Check if the admin is not logged in, redirect to the login page
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit;
}

// Check if the ID is provided via GET and is numeric
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $user_id = (int)$_GET['id'];

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

    // Prepare the SQL query to delete the user
    $sql = "DELETE FROM accounts WHERE id = ?";
    if ($stmt = $mysqli->prepare($sql)) {
        // Bind the user ID parameter to the prepared statement
        $stmt->bind_param('i', $user_id);
        $stmt->execute();

        // Check if the user was deleted successfully
        if ($stmt->affected_rows === 1) {
            // User deleted successfully, redirect back to view_users.php
            header('Location: view_users.php');
            exit;
        } else {
            // Failed to delete user
            echo "Failed to delete user.";
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        // Error in the prepared statement
        echo "An error occurred. Please try again later.";
    }

    // Close the database connection
    $mysqli->close();
} else {
    // Redirect back to view_users.php if the user ID is not provided or is not numeric
    header('Location: view_users.php');
    exit;
}
