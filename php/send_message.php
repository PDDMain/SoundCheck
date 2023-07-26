<?php

// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: ../login.php');
    exit;
}

// Assuming you have already established a database connection
// Replace the database credentials with your actual values
$servername = 'localhost';
$username = 'admin';
$password = '0f4828da8bb2c1de5036206c7bab79319c3ba671516ca6fe';
$dbname = 'example';

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the user_id from wherever you have stored it after user authentication (e.g., from a session)
    // Replace 'your_user_id' with the appropriate code to get the user's ID
    $user_id = $_SESSION['id']; // Replace this with your code to get the actual user ID

    // Get the message text from the form
    $text = $_POST["review"];

    if (empty($text)) {
        header("Location: ../first_page.php");
        exit();
    }
    // Prepare and execute the INSERT query
    $sql = "INSERT INTO messages (id, user_id, text) VALUES (NULL, '$user_id', '$text')";

    if ($conn->query($sql) === TRUE) {
        header("Location: ../first_page.php");
    } else {
        echo "Error adding message: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
