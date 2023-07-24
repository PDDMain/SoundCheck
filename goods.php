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
        <a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
        <a href="basket.php"><i class="fas fa-shopping-basket"></i>Basket</a>
    </div>
</nav>
<div class="content">
    <form action="goods.php" method="get">
        <label for="category">Filter by Category:</label>
        <select name="category" id="category">
            <option value="">All Categories</option>
            <option value="Electronics">Electronics</option>
            <option value="Clothing">Clothing</option>
            <option value="Books">Books</option>
            <!-- Add more categories as needed -->
        </select>
        <input type="submit" value="Filter">
    </form>

    <form action="goods.php" method="get">
        <label for="search">Search by Name:</label>
        <input type="text" name="search" placeholder="Enter search keyword">
        <input type="submit" value="Search">
    </form>

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

    // Prepare the query with filtering based on category and searching based on name
    $filter = "";
    $search = "";
    if (isset($_GET['category']) && !empty($_GET['category'])) {
        $category = $mysqli->real_escape_string($_GET['category']);
        $filter = "WHERE category = '$category'";
    }
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $mysqli->real_escape_string($_GET['search']);
        if ($filter === "") {
            $filter = "WHERE name LIKE '%$search%'";
        } else {
            $filter .= " AND name LIKE '%$search%'";
        }
    }

    // Fetch the goods from the database with applied filtering and searching
    $query = "SELECT id, name, description, image_link FROM goods $filter";
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
            echo '<form action="add_to_basket.php" method="post">';
            echo '<input type="hidden" name="good_id" value="' . $row['id'] . '">';
            echo '<input type="submit" value="To Basket">';
            echo '</form>';
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
