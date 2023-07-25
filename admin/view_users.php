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
$DATABASE_USER = 'root';
$DATABASE_PASS = 'root';
$DATABASE_NAME = 'example';

// Create a connection to the database
$mysqli = new mysqli($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

// Check for connection errors
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

// Fetch users from the database
$sql = "SELECT * FROM accounts";
$result = $mysqli->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Users</title>
    <!-- Add your CSS file link here -->
</head>
<body>
<header>
    <h1>Admin Dashboard - View Users</h1>
    <a href="admin_dashboard.php">Back to Dashboard</a>
    <a href="admin_logout.php">Logout</a>
</header>

<div class="user-list">
    <h2>User List</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>username	</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td>
                    <a href="delete_user.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>

<footer>
    <p>&copy; <?php echo date('Y'); ?> All rights reserved.</p>
</footer>
</body>
</html>

<?php
// Close the database connection
$mysqli->close();
?>
