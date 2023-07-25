<?php
// Check if the item ID is sent via GET
if (isset($_POST['user_id'], $_POST['good_id'])) {
    $user_id = $_POST['user_id'];
    $good_id = $_POST['good_id'];

    // Change this to your database connection details
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

    // Prepare and execute the query to remove the item from the basket
    $query = 'DELETE FROM basket WHERE user_id = ' . $user_id . ' AND good_id = ' . $good_id;
    if ($stmt = $mysqli->prepare($query)) {

        // Execute the query
        if ($stmt->execute()) {
            // Item removed successfully, you can perform additional actions if needed
            // For example, you can redirect the user back to the basket page
            header('Location: ../basket.php');
            exit();
        } else {
            echo "Error executing query: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error preparing query: " . $mysqli->error;
    }

    // Close the database connection
    $mysqli->close();
} else {
    echo "Missing item ID.";
}
?>
