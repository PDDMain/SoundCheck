<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link href="css/admin_login.css" rel="stylesheet" type="text/css">
    <link href="css/header.css" rel="stylesheet" type="text/css">
</head>
<body>
<header>
    <div><a href="../main.php"><img class="logo" src="../img/logo.jpg"></a></div>
    <h2>Admin Panel</h2>
    <nav>
        <ul>
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="view_users.php">View Users</a></li>
            <li><a href="add_product.php">Add product</a></li>
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
            <input type="submit" value="Login">
        </form>
    </div>
</main>
</body>
</html>
