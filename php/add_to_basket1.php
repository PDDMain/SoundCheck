<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: ../login.php');
    exit;
}

// Check if the product ID is provided via POST
if (isset($_POST['good_id']) && !empty($_POST['good_id'])) {
    // Database connection details
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'admin';
    $DATABASE_PASS = '0f4828da8bb2c1de5036206c7bab79319c3ba671516ca6fe';
    $DATABASE_NAME = 'example';

    // Try and connect using the info above.
    $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

    // Check for connection errors
    if (mysqli_connect_errno()) {
        // If there is an error with the connection, stop the script and display the error.
        exit('Failed to connect to MySQL: ' . mysqli_connect_error());
    }

    // Retrieve the user ID from the session
    $user_id = $_SESSION['id'];

    // Get the product ID from the POST data
    $good_id = $con->real_escape_string($_POST['good_id']);

    echo "user_id = `$user_id`, good_id = `$good_id`";
    // Check if the product is already in the basket
//    $check_query = "SELECT id FROM basket WHERE user_id = $user_id AND good_id = $good_id";
    if ($stmt = $con->prepare("SELECT user_id, good_id FROM basket WHERE user_id = $user_id AND good_id = $good_id")) {
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 0) {
            // Insert the product into the basket
            $insert_query = "INSERT INTO basket (user_id, good_id, count) VALUES ($user_id, $good_id, 1)";
            echo "$insert_query";
            if ($stmt = $con->prepare($insert_query)) {
                echo "$insert_query";
                $stmt->execute();

                header('Location: ../basket.php');
                exit;
            }
            $stmt->close();
        }
    }

    // Close the database connection
    $con->close();
}

// Redirect back to the goods.php page after adding to the basket
header('Location: ../basket.php');
exit;
?>
