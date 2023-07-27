<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

if (isset($_GET['type'])) {
    $_SESSION['type'] = $_GET['type'];
}
if (empty($_SESSION['type'])) {
    $_SESSION['type'] = 'All';
}?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="css/main_style.css">
    <link rel="stylesheet" rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
<header>
    <div class="header-navigation">
    <div><a href="first_page.php"><img class="logo" src="img/logo.jpg"></a></div>
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
    </div>
    <div class="header-cathegories">
        <a class="cath" href="main.php?type=All" <?php if ($_SESSION['type'] === 'All') { echo "style=\"color: #FF4386; \""; } ?>>All</a>
        <a class="cath" href="main.php?type=in-ear" <?php if ($_SESSION['type'] === 'in-ear') { echo "style=\"color: #FF4386; \""; } ?>>In-ear</a>
        <a class="cath" href="main.php?type=over-ear" <?php if ($_SESSION['type'] === 'over-ear') { echo "style=\"color: #FF4386; \""; } ?>>Over-ear</a>
        <a class="cath" href="main.php?type=wireless" <?php if ($_SESSION['type'] === 'wireless') { echo "style=\"color: #FF4386; \""; } ?>>Wireless</a>
    </div>
</header>
    <main>
    <div class="filters">
        <form action="main.php" method="get">
            <h1>Filters</h1>

            <h2>Brands</h2>
            <input class="filters_checkbox" type="checkbox" name="category" value="Samsung"> Samsung
            <span class="filters_checkmark"></span>
            <br>
            <input class="filters_checkbox" type="checkbox" name="category" value="Apple"> Apple
            <br>
            <input class="filters_checkbox" type="checkbox" name="category" value="Sony"> Sony
            <br>
            <input class="filters_checkbox" type="checkbox" name="category" value="Xiaomi"> Xiaomi
            <br>
            <input class="filters_checkbox" type="checkbox" name="category" value="JVC"> JVC
            <br>
            <input class="filters_checkbox" type="checkbox" name="category" value="JBL"> JBL
            <br>
            <input class="filters_checkbox" type="checkbox" name="category" value="Meze"> Meze
            <br>
            <input class="filters_checkbox" type="checkbox" name="category" value="Sennheiser"> Sennheiser


            <h2>Price</h2>
            <label for="minPrice">From:</label>
            <input class="filters_price" type="number" name="minPrice" id="minPrice" min="0">
            <br>
            <label for="maxPrice">To:</label>
            <input class="filters_price" type="number" name="maxPrice" id="maxPrice" min="0">

            <h2>Colors</h2>
            <select class="selector" name="brand">
                <option value="">Select a color</option>
                <option value="Black">Black</option>
                <option value="White">White</option>
                <option value="Red">Red</option>
                <option value="Blue">Blue</option>
                <option value="Purple">Purple</option>
                <!-- Add more brands as needed -->
            </select>
            <input type="submit" id="filter_button" value="Filter">
        </form>
    </div>


<div class="items">
    <!--    <div class="square">-->
    <!--        <form action="php/add_to_basket.php" method="post">-->
    <!--            <a href="https://www.google.com/"><img class="product" src="img/product.jpg" alt=""></a>-->
    <!--            <div class="name"> Very expensive earphones</div>-->
    <!--            <div class="price">-->
    <!--                <div class="price-text">1999$</div>-->
    <!--                <div class="change_amount">-->
    <!--                    <button class="plus_button">+</button>-->
    <!--                    <label class="amount_of_item">1</label>-->
    <!--                    <button class="minus_button">-</button>-->
    <!--                </div>-->
    <!--            </div>-->
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
    if (isset($_GET['type'])) {
        $_SESSION['type'] = $_GET['type'];
    }
    if (empty($_SESSION['type'])) {
        $_SESSION['type'] = 'All';
    }
    if ($_SESSION['type'] !== 'All') {
        $type = $mysqli->real_escape_string($_SESSION['type']);
        $filter = "WHERE type = '$type'";
    }
    if (isset($_GET['category']) && !empty($_GET['category'])) {
        $category = $mysqli->real_escape_string($_GET['category']);
        if ($filter === "") {
            $filter = "WHERE category = '$category'";
        } else {
            $filter .= "AND category = '$category'";
        }
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
            $user_id = $_SESSION['id'];
            $query1 = 'SELECT basket.count FROM goods 
              INNER JOIN basket ON goods.id = basket.good_id 
              WHERE basket.user_id = ' . $user_id . ' AND basket.good_id = ' . $row['id'];
            $result1 = $mysqli->query($query1);

            echo '<div class="square">';
            if ($result1->num_rows === 0) {
                echo '<form class="buy_button_form" action="php/add_to_basket.php" method="post">';
            }
            echo '<a href=product_page.php?good_id="' . $row['id'] . '"><img class="product" src="' . $row['image_link'] . '" alt=""></a>';
            echo '<div class="name"> <a class="name" href=product_page.php?good_id="' . $row['id'] . '">' . $row['name'] . '</a></div>';
            echo '<div class="price">';
            echo '<div class="price-text">' . $row['price'] . '$</div>';
            if ($result1->num_rows > 0) {
                $row1 = $result1->fetch_assoc();
                echo '<form action="php/basket_inc.php" method="post" class="change_amount">';
                echo '<input type="hidden" name="user_id" value="' . $user_id . '">';
                echo '<input type="hidden" name="good_id" value="' . $row['id'] . '">';
                echo '<input type="hidden" name="return_page" value="main.php">';
                echo '<div class="amounts_buttons">';
                echo '<button type="submit" name="action" value="decrease" class="minus_button">-</button>';
                echo '<label class="amount_of_item">' . $row1['count'] . '</label>';
                echo '<button type="submit" name="action" value="increase" class="plus_button">+</button>';
                echo '</div>';
                echo '</form>';
            } else {
                echo '<input type="hidden" name="good_id" value="' . $row['id'] . '">';
                echo '<input type="submit" value="Buy" class="buy_button">';
            }
            echo '</div>';
            if ($result1->num_rows === 0) {
                echo '</form>';
            }
            echo '</div>';
        }
        echo '</div>';
    } else {
        echo 'No goods found.';
    }

    // Close the database connection
    $mysqli->close();
    ?>
</div>
</main>
<footer class="footer">
    <!-- Footer content goes here -->
    <p>&copy; 2023 All rights reserved.</p>
</footer>
</body>
</html>