<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.html');
    exit;
}

// Check if the product ID is provided via POST
if (isset($_POST['good_id']) && !empty($_POST['good_id'])) {
    // Database connection details
    $host = 'localhost';
    $username = 'root';
    $password = 'root';
    $database = 'example';

    // Create a new MySQLi object
    $mysqli = new mysqli($host, $username, $password, $database);

    // Check for connection errors
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli->connect_error;
        exit();
    }

    // Retrieve the user ID from the session
    $user_id = $_SESSION['id'];

    // Get the product ID from the POST data
    $good_id = $mysqli->real_escape_string($_POST['good_id']);

    // Check if the product is already in the basket for the user
    $check_query = "SELECT count FROM basket WHERE user_id = $user_id AND good_id = $good_id";
    $check_result = $mysqli->query($check_query);

    if ($check_result->num_rows === 0) {
        // If the product is not in the basket, insert it with count=1
        $insert_query = "INSERT INTO basket (user_id, good_id, count) VALUES ($user_id, $good_id, 1)";
        $mysqli->query($insert_query);
    } else {
        // If the product is already in the basket, increment its count
        $row = $check_result->fetch_assoc();
        $current_count = $row['count'];
        $new_count = $current_count + 1;

        $update_query = "UPDATE basket SET count = $new_count WHERE user_id = $user_id AND good_id = $good_id";
        $mysqli->query($update_query);
    }

    // Close the database connection
    $mysqli->close();
}

// Redirect back to the goods.php page after adding to the basket
header('Location: goods.php');
exit;
?>
