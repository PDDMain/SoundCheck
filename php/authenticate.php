<?php
session_start();
// Change this to your connection info.
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = 'root';
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
if (!isset($_POST['username'], $_POST['password'])) {
    // Could not get the data that should have been sent.
    $error_message = "Please fill both the username and password fields!"; // Set your custom error message here.
    $encoded_message = urlencode($error_message); // URL-encode the error message to handle special characters.

    // Redirect the user to the error page with the error message as a query parameter.
    $_SESSION['login_error'] = $encoded_message;
    header('Location: ../login.php');
    exit();
}
// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
    // Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    // Store the result so we can check if the account exists in the database.
    $stmt->store_result();


    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password);
        $stmt->fetch();
        // Account exists, now we verify the password.
        // Note: remember to use password_hash in your registration file to store the hashed passwords.
        if ($_POST['password'] === $password) {
            // Verification success! User has logged-in!
            // Create sessions, so we know the user is logged in, they basically act like cookies but remember the data on the server.
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['id'] = $id;
            header('Location: ../main.php');
        } else {
            // Incorrect password
            $error_message = "Incorrect username and/or password!"; // Set your custom error message here.

            // Redirect the user to the error page with the error message as a query parameter.
            $_SESSION['login_error'] = $error_message;
            header('Location: ../login.php');
            exit();
        }
    } else {
        // Incorrect username
        $error_message = "Incorrect username and/or password!"; // Set your custom error message here.

        // Redirect the user to the error page with the error message as a query parameter.
        $_SESSION['login_error'] = $error_message;
        header('Location: ../login.php');
    }


    $stmt->close();
}
?>
