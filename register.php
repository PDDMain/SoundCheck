<?php
// Change this to your connection info.
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = 'root';
$DATABASE_NAME = 'example';

// Try and connect using the info above.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    // If there is an error with the connection, stop the script and display the error.
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// Now we check if the data from the login form was submitted, isset() will check if the data exists.
if (!isset($_POST['register_username'], $_POST['register_password'])) {
    // Could not get the data that should have been sent.
    exit('Please fill both the username and password fields!');
}

// Check if the username is already taken
if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
    $stmt->bind_param('s', $_POST['register_username']);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo 'Username already taken.';
    } else {
        // Insert the new account into the database (Make sure to hash the password)
        $register_query = 'INSERT INTO accounts (id, username, password, email) VALUES (NULL, ?, ?, \'\');';
        if ($stmt = $con->prepare($register_query)) {
            $stmt->bind_param('ss', $_POST['register_username'], $_POST['register_password']);
            $stmt->execute();
            // Registration successful, you can redirect to the login page or display a success message
            header('Location: login.html');
            exit;
        } else {
            echo 'Registration failed. Please try again later.';
        }
    }

    $stmt->close();
}

$con->close();
?>
