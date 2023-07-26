<?php
session_start();

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Change this to your connection info.
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = 'root';
    $DATABASE_NAME = 'example';

    // Create a connection to the database
    $mysqli = new mysqli($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

    // Check for connection errors
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli->connect_error;
        exit();
    }

    // Get the admin credentials from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    echo "$username";
    echo "$password";

    // Prepare the SQL query to check admin credentials
    $sql = "SELECT * FROM admin_users WHERE username = ? AND password = ?";
    if ($stmt = $mysqli->prepare($sql)) {
        // Bind parameters to the prepared statement
        $stmt->bind_param('ss', $username, $password);
        $stmt->execute();

        // Store the result so we can check if the admin exists in the database
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            // Admin authenticated, set session to remember admin login
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $username;
            header('Location: admin_dashboard.php');
            exit;
        } else {
            // Admin login failed, show error message
            $_SESSION['login_error'] = 'Invalid admin credentials.';
            header('Location: admin_login.php');
            exit;
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        // Error in the prepared statement
        $_SESSION['login_error'] = 'An error occurred. Please try again later.';
        header('Location: admin_login.php');
        exit;
    }

    // Close the database connection
    $mysqli->close();
} else {
    // Redirect to the login page if the form was not submitted
    header('Location: admin_login.php');
    exit;
}
