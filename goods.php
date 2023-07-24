<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.html');
    exit;
} ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>List of Goods</title>
    <link href="style.css" rel="stylesheet" type="text/css">
</head>
<body class="loggedin">
<nav class="navtop">
    <div>
        <a href="home.php" class="title"><h1>Website Title</h1></a>
        <a href="goods.php"><i class="fas fa-user-circle"></i>Goods</a>
        <a href="create_good.php"><i class="fas fa-user-circle"></i>Create good</a>
        <a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
    </div>
</nav>
<div class="content">
<?php
// Database connection details
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

// Fetch the goods from the database
$query = "SELECT id, name, description, image_link FROM goods";
$result = $mysqli->query($query);

// Display the goods
if ($result->num_rows > 0) {
    echo '<ul class="goods-list">';
    while ($row = $result->fetch_assoc()) {
        echo '<li class="goods-item">';
        echo '<img src="' . $row['image_link'] . '" alt="Goods Image" class="goods-image">';
        echo '<div>';
        echo '<h3 class="goods-name">' . $row['name'] . '</h3>';
        echo '<p>' . $row['description'] . '</p>';
        echo '</div>';
        echo '</li>';
    }
    echo '</ul>';
} else {
    echo 'No goods found.';
}

// Close the database connection
$mysqli->close();
?>

</div>
</body>
</html>
