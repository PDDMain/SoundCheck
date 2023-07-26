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
    header('Location: ../register.php?error=' . $error_message);
    exit;
}

// Now we check if the data from the login form was submitted, isset() will check if the data exists.
if (!isset($_POST['username'], $_POST['email'], $_POST['password'])) {
    // Could not get the data that should have been sent.
    $error_message = "Please fill both the username, email and password fields!"; // Set your custom error message here.
    header('Location: ../register.php?error=' . $error_message);
    exit;
}

// Check if the username is already taken
if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $error_message = "Username already taken."; // Set your custom error message here.

        header('Location: ../register.php?error=' . $error_message);
        exit();
    } else {
        // Insert the new account into the database (Make sure to hash the password)
        $register_query = 'INSERT INTO accounts (id, username, first_name, second_name, password, email, phone) VALUES (NULL, ?, ?, ?, ?, ?, 0);';
        if ($stmt = $con->prepare($register_query)) {
            $stmt->bind_param('sssss', $_POST['username'], $_POST['first_name'], $_POST['last_name'], $_POST['password'], $_POST['email']);
            $stmt->execute();
            // Registration successful, you can redirect to the login page or display a success message
            header('Location: ../login.php');
            exit;
        } else {
            $error_message = "Registration failed. Please try again later."; // Set your custom error message here.

            header('Location: ../register.php?error=' . $error_message);
            exit;
        }
    }

    $stmt->close();
}

$con->close();
?>
