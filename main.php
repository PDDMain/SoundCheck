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
    <link rel="stylesheet" rel="stylesheet" href="css/header.css">
</head>
<body>
<header>
    <div><a href="main.php"><img class="logo" src="img/logo.jpg"></a></div>
    <div class="search-container">
        <form class="search" action="main.php" method="get">
            <input type="text" name="search" placeholder="Search">
            <button type="submit" class="search-button">Search</button>
        </form>
    </div>
    <nav>
        <ul>
            <li><a href="profile.php">
                    <div class="user-container">
                        <img class="user" src="img/user_icon.jpg">
                        <img class="user-hover" src="img/user_icon_hover.jpg">
                    </div>
                </a></li>
            <li><a href="basket.php">
                    <div class="cart-container">
                        <img class="cart" src="img/shopping_cart_icon.jpg">
                        <img class="cart-hover" src="img/shopping_cart_icon_hover.jpg">
                    </div>
                </a></li>
        </ul>
    </nav>
</header>
<div class="container_aside">
<aside class="filters">
    <form action="main.php" method="get">
    <h1>Filters</h1>

    <h2>Brands</h2>
    <input type="checkbox" name="category" value="Samsung"> Samsung
    <br>
    <input type="checkbox" name="category" value="Apple"> Apple
    <br>
    <input type="checkbox" name="category" value="Xiaomi"> Xiaomi
    <br>
    <input type="checkbox" name="category" value="JVC"> JVC
    <br>
    <input type="checkbox" name="category" value="Meze"> Meze
    <br>
    <input type="checkbox" name="category" value="Sennheiser"> Sennheiser


    <h2>Price</h2>
    <label for="minPrice">From:</label>
    <input type="number" name="minPrice" id="minPrice" min="0">
    <br>
    <label for="maxPrice">To:</label>
    <input type="number" name="maxPrice" id="maxPrice" min="0">

    <h2>Colors</h2>
    <select name="brand">
        <option value="">Select a color</option>
        <option value="Black">Black</option>
        <option value="White">White</option>
        <option value="Blue">Blue</option>
        <!-- Add more brands as needed -->
    </select>
    <input type="submit" id="filter_button" value="Filter">
    </form>
</aside>
</div>
<main>

<!--    <div class="square">-->
<!--        <form action="php/add_to_basket.php" method="post">-->
<!--        <a href="https://www.google.com/"><img class="product" src="img/product.jpg" alt=""></a>-->
<!--        <div class="name"> Very expensive earphones</div>-->
<!--        <div class="price">-->
<!--            <div class="price-text">1999$</div>-->

<!--    <div class="change_amount">-->
<!--        <button class="plus_button">+</button>-->
<!--        <label class="amount_of_item">1</label>-->
<!--       <button class="minus_button">-</button>-->
<!--    </div>-->

<!--        </div>-->
<!--        </form>-->
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
    if (isset($_GET['brand']) && !empty($_GET['brand'])) {
        $color = $mysqli->real_escape_string($_GET['brand']);
        if ($filter === "") {
            $filter = "WHERE color = '$color'";
        } else {
            $filter .= "AND color = '$color'";
        }
    }
    if (isset($_GET['minPrice']) && !empty($_GET['minPrice'])) {
        $minPrice = $mysqli->real_escape_string($_GET['minPrice']);
        if ($filter === "") {
            $filter = "WHERE price >= '$minPrice'";
        } else {
            $filter .= "AND price >= '$minPrice'";
        }
    }
    if (isset($_GET['maxPrice']) && !empty($_GET['maxPrice'])) {
        $maxPrice = $mysqli->real_escape_string($_GET['maxPrice']);
        if ($filter === "") {
            $filter = "WHERE price <= '$maxPrice'";
        } else {
            $filter .= "AND price <= '$maxPrice'";
        }
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
            echo '<form action="php/add_to_basket.php" method="post">';
            echo '<a href=product_page.php?good_id="' . $row['id'] . '"><img class="product" src="' . $row['image_link'] . '" alt=""></a>';
            echo '<div class="name"> <a class="name" href=product_page.php?good_id="' . $row['id'] . '">' . $row['name'] . '</a></div>';
            echo '<div class="price">';
            echo '<div class="price-text">' . $row['price'] . '$</div>';
            echo '<input type="submit" value="Buy" class="buy_button">';
            echo '</div>';
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