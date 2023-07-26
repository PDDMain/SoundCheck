<?php
// Change this to your connection info.
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'admin';
$DATABASE_PASS = '0f4828da8bb2c1de5036206c7bab79319c3ba671516ca6fe';
$DATABASE_NAME = 'example';

// Try and connect using the info above.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    // If there is an error with the connection, stop the script and display the error.
    $error_message = "Unknown error!"; // Set your custom error message here.
    $encoded_message = urlencode($error_message); // URL-encode the error message to handle special characters.

    // Redirect the user to the error page with the error message as a query parameter.
    header("Location: ../error_page.php?message=$encoded_message");
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// Now we check if the data from the login form was submitted, isset() will check if the data exists.
if (!isset($_POST['username'], $_POST['email'], $_POST['password'])) {
    // Could not get the data that should have been sent.
    $error_message = "Please fill both the username, email and password fields!"; // Set your custom error message here.
    $encoded_message = urlencode($error_message); // URL-encode the error message to handle special characters.

    // Redirect the user to the error page with the error message as a query parameter.
    header("Location: ../error_page.php?message=$encoded_message");
    exit('Please fill both the username, email and password fields!');
}

// Check if the username is already taken
if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $error_message = "Username already taken."; // Set your custom error message here.
        $encoded_message = urlencode($error_message); // URL-encode the error message to handle special characters.

        // Redirect the user to the error page with the error message as a query parameter.
        header("Location: ../error_page.php?message=$encoded_message");
    } else {
        // Insert the new account into the database (Make sure to hash the password)
        $register_query = 'INSERT INTO accounts (id, username, password, email) VALUES (NULL, ?, ?, ?);';
        if ($stmt = $con->prepare($register_query)) {
            $stmt->bind_param('sss', $_POST['username'], $_POST['password'], $_POST['email']);
            $stmt->execute();
            // Registration successful, you can redirect to the login page or display a success message
            header('Location: ../login.html');
            exit;
        } else {
            $error_message = "Registration failed. Please try again later."; // Set your custom error message here.
            $encoded_message = urlencode($error_message); // URL-encode the error message to handle special characters.

            // Redirect the user to the error page with the error message as a query parameter.
            header("Location: ../error_page.php?message=$encoded_message");
        }
    }

    $stmt->close();
}

$con->close();
?>
