<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link href="css/admin_login.css" rel="stylesheet" type="text/css">
    <link href="css/header.css" rel="stylesheet" type="text/css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
<header>
    <div><a href="../main.php"><img class="logo" src="../img/logo.jpg"></a></div>
    <h2>Admin Panel</h2>
    <nav>
        <ul>
            <li><a href="admin_dashboard.php">Dashboard</a></li>
        </ul>
    </nav>
</header>
<main>
    <div class="login_form">
        <h1>Login</h1>
        <form action="admin_authenticate.php" method="post">
            <label for="username">
                <i class="fas fa-user"></i>
            </label>
            <input type="text" name="username" placeholder="Username" id="username" required>
            <label for="password">
                <i class="fas fa-lock"></i>
            </label>
            <input type="password" name="password" placeholder="Password" id="password" required>

            <?php
            // Display the login error message (if set) from the session
            session_start();
            if (isset($_SESSION['login_error'])) {
                echo '<div class="error">' . $_SESSION['login_error'] . '</div>';
                unset($_SESSION['login_error']); // Clear the error message after displaying it
            }
            ?>
            <input type="submit" value="Login">
        </form>
    </div>
</main>
</body>
</html>
