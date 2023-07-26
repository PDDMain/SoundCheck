<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="css/product_style.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
<header>

    <div class="header-navigation">
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
    </div>
    <div class="header-cathegories">
        <a class="cath" href="#">In-ear</a>
        <a class="cath" href="#">Over-ear</a>
        <a class="cath" href="#">Wireless</a>
    </div>
</header>
<div class="gap"></div>
<div></div>
<main>
    <!-- Product details section -->
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

    // Check if the goal ID is provided via GET
    if (isset($_GET['good_id']) && !empty($_GET['good_id'])) {
        $good_id = $_GET['good_id'];
        // Fetch the goal details from the database
        $query = "SELECT id, name, price, description, image_link FROM goods WHERE id = $good_id";
        $result = $mysqli->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo '<div class="product-details">';
            echo '<div class="image_n_price">';
            echo '<div class="img_n_prc">';
            echo '<img src="' . $row['image_link'] . '" alt="Product Name">';
            echo '<hr>';
            echo '<div class="price">';
            echo '<div class="price-text">' . $row['price'] . '$</div>';
            echo '<button class="add-to-cart">Add to Cart</button>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '<div class="product-info">';
            echo '<div class="prof_inf">';
            echo '<h1 class="product-name">' . $row['name'] . '</h1>';
            echo '<hr>';
            echo '<p class="product-description">Description</p>';
            echo '<p class="product-description">';
            echo $row['description'];
            echo '</p>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        } else {
            echo 'Product not found.';
        }
    } else {
        echo 'Invalid product ID.';
    }


    // Close the database connection
    $mysqli->close();
    ?>

</main>
<footer class="footer">
    <!-- Footer content goes here -->
    <p>&copy; 2023 All rights reserved.</p>
</footer>
</body>
</html>