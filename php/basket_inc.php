<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if the necessary data is sent via POST

    if (isset($_POST['user_id'], $_POST['good_id'], $_POST['action'])) {
        $user_id = $_POST['user_id'];
        $good_id = $_POST['good_id'];
        $return_page = $_POST['return_page'];
        $action = $_POST['action'];

        // Validate the action
        if ($action === 'increase' || $action === 'decrease') {
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
            $query = 'SELECT count FROM basket WHERE user_id = ' . $user_id . ' AND good_id = ' . $good_id;
            $result = $mysqli->query($query);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $count = $row['count'];
                // Check if the count is 1 and the action is 'decrease'
                if ($count < 2 && $action === 'decrease') {
                    // If count is 1, do not decrease further
                    header('Location: ../' . $return_page);
                    exit();
                }
                // Prepare and execute the query to update the count
                if ($action === 'increase') {
                    $query = 'UPDATE basket SET count = count + 1 WHERE user_id = ' . $user_id . ' AND good_id = ' . $good_id;
                } else {
                    $query = 'UPDATE basket SET count = count - 1 WHERE user_id = ' . $user_id . ' AND good_id = ' . $good_id;
                }

                // Prepare the query
                if ($stmt = $mysqli->prepare($query)) {
                    // Execute the query
                    if ($stmt->execute()) {
                        // Query executed successfully, you can perform additional actions if needed
                        // For example, you can redirect the user back to the basket page
                        header('Location: ../' . $return_page);
                        exit();
                    } else {
                        echo "Error executing query: " . $stmt->error;
                    }

                    // Close the statement
                    $stmt->close();
                } else {
                    echo "Error preparing query: " . $mysqli->error;
                }

            }
            // Close the database connection
            $mysqli->close();
        } else {
            echo "Invalid action.";
        }
    } else {
        echo "Missing required data.";
    }
}
?>
