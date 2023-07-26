<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <!-- Add your CSS file link here -->
</head>
<body>
<div class="login-form">
    <h1>Admin Login</h1>
    <?php
    // Display the login error message (if set) from the session
    session_start();
    if (isset($_SESSION['login_error'])) {
        echo '<p class="error-message">' . $_SESSION['login_error'] . '</p>';
        unset($_SESSION['login_error']); // Clear the error message after displaying it
    }
    ?>
    <form action="admin_authenticate.php" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <input type="submit" value="Login">
    </form>
</div>
</body>
</html>
