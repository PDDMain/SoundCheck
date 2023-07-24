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
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="css/main_style.css">
</head>
<body>
<header>
    <div class="logo"><img class="logo_pic" src="img/logo.jpg"> </div>
    <input type="text" placeholder="Search" class="search">
    <nav>
        <ul>
            <li><a href="#"><img class="icon" src="img/user_icon.jpg"></a></li>
            <li><a href="#"><img class="icon" src="img/shopping_cart_icon.jpg"></a></li>
        </ul>
    </nav>
</header>

<aside class="filters">
    <form action="main.php" method="get">
    <h1>Filters</h1>

    <h2>Brands</h2>
    <input type="checkbox" name="category" value="Samsung"> Samsung
    <br>
    <input type="checkbox" name="category" value="Apple"> Apple
    <br>
    <input type="checkbox" name="category" value="Xiaomi"> Xiaomi


    <h2>Price</h2>
    <label for="minPrice">From:</label>
    <input type="number" name="minPrice" id="minPrice" min="0">
    <br>
    <label for="maxPrice">To:</label>
    <input type="number" name="maxPrice" id="maxPrice" min="0">

    <h2>Colors</h2>
    <select name="brand">
        <option value="">Select a color</option>
        <option value="brand1">Black</option>
        <option value="brand2">White</option>
        <option value="brand3">Blue</option>
        <!-- Add more brands as needed -->
    </select>
    <input type="submit" value="Filter">
    </form>
</aside>
<main>
    <br>
    <br>
    <br>
    <br>

<!--    <div class="square">-->
<!---->
<!--        <a href="#"><img class="product" src="img/product.jpg" alt=""></a>-->
<!--        <label class="name"> Good earphones</label>-->
<!--        <br>-->
<!--        <label class="price">199$</label>-->
<!--        <input type="submit" value="Buy" class="buy_button">-->
<!--    </div>-->
<!---->
<!--    <div class="square">-->
<!---->
<!--        <a href="#"><img class="product" src="img/product.jpg" alt=""></a>-->
<!--        <label class="name"> Best earphones</label>-->
<!--        <br>-->
<!--        <label class="price">1999$</label>-->
<!---->
<!--        <input type="submit" value="Buy" class="buy_button">-->
<!--    </div>-->
<!--    <div class="square">-->
<!---->
<!--        <a href="#"><img class="product" src="img/product.jpg" alt=""></a>-->
<!--        <label class="name"> Not bad earphones</label>-->
<!--        <br>-->
<!--        <label class="price">19$</label>-->
<!---->
<!--        <input type="submit" value="Buy" class="buy_button">-->
<!--    </div>-->
<!--    <div class="square">-->
<!---->
<!--        <a href="#"><img class="product" src="img/product.jpg" alt=""></a>-->
<!--        <label class="name"> Very expensive earphones</label>-->
<!--        <br>-->
<!--        <label class="price">19999$</label>-->
<!---->
<!--        <input type="submit" value="Buy" class="buy_button">-->
<!--    </div>-->

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
    $query = "SELECT id, name, description, image_link, price FROM goods $filter";
    $result = $mysqli->query($query);

    // Display the goods
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="square">';
            echo '<a href="#"><img class="product" src="' . $row['image_link'] . '" alt=""></a>';
            echo '<label class="name"> ' . $row['name'] . '</label>';
            echo '<br>';
            echo '<label class="price">' . $row['price'] . '$</label>';
            echo '<form action="add_to_basket.php" method="post">';
            echo '<input type="hidden" name="good_id" value="' . $row['id'] . '">';
            echo '<input type="submit" value="Buy" class="buy_button">';
            echo '</form>';
            echo '</div>';
        }
        echo '</ul>';
    } else {
        echo 'No goods found.';
    }

    // Close the database connection
    $mysqli->close();
    ?>

</main>
<footer>

</footer>
</body>
</html>