<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
} ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Basket</title>
    <link rel="stylesheet" href="css/basket_style.css">
    <link rel="stylesheet" href="css/header.css">
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
        <a class="cath" href="main.php?type=All">All</a>
        <a class="cath" href="main.php?type=in-ear">In-ear</a>
        <a class="cath" href="main.php?type=over-ear">Over-ear</a>
        <a class="cath" href="main.php?type=wireless">Wireless</a>
    </div>
</header>

<main>
    <div class="items">
    <?php
    $host = 'localhost';
    $username = 'admin';
    $password = '0f4828da8bb2c1de5036206c7bab79319c3ba671516ca6fe';
    $database = 'example';

    // Create a new MySQLi object
    $mysqli = new mysqli($host, $username, $password, $database);

    // Check for connection errors
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli->connect_error;
        exit();
    }

    // Retrieve the user ID from the session
    $user_id = $_SESSION['id'];
    $query1 = "SELECT goods.price, basket.count FROM goods 
              INNER JOIN basket ON goods.id = basket.good_id 
              WHERE basket.user_id = $user_id";

    $result1 = $mysqli->query($query1);
    $items = 0;
    $price = 0;
    if ($result1->num_rows > 0) {
        while ($row = $result1->fetch_assoc()) {
            $items = $items + $row['count'];
            $price = $price + ($row['price'] * $row['count']);
        }
    }
    // Database connection details

    // Fetch the goods from the database that are in the user's basket
    $query = "SELECT goods.id, goods.name, goods.price, goods.description, goods.image_link, basket.count FROM goods 
              INNER JOIN basket ON goods.id = basket.good_id 
              WHERE basket.user_id = $user_id";

    $result = $mysqli->query($query);

    // Display the goods in the basket
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="item">';
            echo '<div class="left_item">';
            echo '<a href=product_page.php?good_id="' . $row['id'] . '"><img class="product" src="' . $row['image_link'] . '" alt=""></a>';
            echo '</div>';
            echo '<div class="right_item">';
//            echo '<div class="top_right_item">';
            echo '<form action="php/basket_delete.php" method="post" class="top_right_item">';


            echo '<div class="name_div">';
            echo '<label class="name">' . $row['name'] . '</label>';
            echo '</div>';


            echo '<input type="hidden" name="user_id" value="' . $user_id . '">';
            echo '<input type="hidden" name="good_id" value="' . $row['id'] . '">';

            echo '<div class="delete_div">';
            echo '<button class="delete_button">Remove</button>';
            echo '</div>';

            echo '</form>';
//            echo '</div>';


            echo '<form action="php/basket_inc.php" method="post" class="bottom_right_item">';
            echo '<input type="hidden" name="user_id" value="' . $user_id . '">';
            echo '<input type="hidden" name="good_id" value="' . $row['id'] . '">';
            echo '<input type="hidden" name="return_page" value="basket.php">';


            echo '<div class="price_div">';
            echo '<label class="price_of_item">' . $row['price'] . '$</label>';
            echo '</div>';

            echo '<div class="amount_div">';
            echo '<div class="change_amount">';

            echo '<button type="submit" name="action" value="decrease" class="minus_button">-</button>';
            echo '<label class="amount_of_item">' . $row['count'] . '</label>';
            echo '<button type="submit" name="action" value="increase" class="plus_button">+</button>';


            echo '</div>';

            echo '</div>';



            echo '</form>';


            echo '</div>';
            echo '</div>';
        }
    }

    // Close the database connection
    $mysqli->close();
    ?>
    </div>
    <div class="buy">
        <?php
        echo '<p>Total (' . $items . ' items): <label class="all_price">' . $price . '$</label> </p>'
        ?>
        <a href="order.php"><input type="submit" src="order.php" value="Order"></a>
    </div>
</main>

<footer class="footer">
    <!-- Footer content goes here -->
    <p>&copy; 2023 All rights reserved.</p>
</footer>
</body>
</html>