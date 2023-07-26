<?php
// Start the session to check if admin is logged in
session_start();

// Check if the admin is not logged in, redirect to the login page
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit;
}

// Change this to your connection info.
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'admin';
$DATABASE_PASS = '0f4828da8bb2c1de5036206c7bab79319c3ba671516ca6fe';
$DATABASE_NAME = 'example';

// Create a connection to the database
$mysqli = new mysqli($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

// Check for connection errors
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

// Fetch users from the database
$sql = "SELECT * FROM messages";
$result = $mysqli->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/view_user.css">
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
            <li><a href="admin_logout.php">Logout</a></li>
        </ul>
    </nav>
</header>
<div class="gap"></div>
<div></div>
<main>
    <div class="user-list">
        <h2>Review List</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>UserID</th>
                <th style="white-space: nowrap">Text</th>
                <th style="white-space: nowrap">Time</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['user_id']; ?></td>
                    <td><?php echo $row['text']; ?></td>
                    <td><?php echo $row['time']; ?></td>
                    <td>
                        <a href="delete_review.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this review?')">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</main>
</body>
</html>
