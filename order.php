<?php
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['id'];

$servername = 'localhost';
$username = 'admin';
$password = '0f4828da8bb2c1de5036206c7bab79319c3ba671516ca6fe';
$dbname = 'example';

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

$query1 = "SELECT goods.price, basket.count FROM goods 
              INNER JOIN basket ON goods.id = basket.good_id 
              WHERE basket.user_id = $user_id";

$result1 = $conn->query($query1);
$items = 0;
$price = 0;
if ($result1->num_rows > 0) {
    while ($row = $result1->fetch_assoc()) {
        $items = $items + $row['count'];
        $price = $price + ($row['price'] * $row['count']);
    }
}

function addZeros($number) {
    // Convert the number to a string
    $number_str = strval($number);

    // Calculate the number of zeros needed to reach a length of 6
    $zeros_needed = 6 - strlen($number_str);

    // Add zeros to the beginning of the string
    for ($i = 0; $i < $zeros_needed; $i++) {
        $number_str = '0' . $number_str;
    }

    return $number_str;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="css/order_style.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
<header>
    <div class="header-navigation">
        <div><a href="first_page.php"><img class="logo" src="img/logo.jpg"></div></a>
        <div class="search-container">
            <div class="search">
                <input type="text" placeholder="Search">
                <button class="search-button">Search</button>
            </div>
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
    <div class="gap"></div>
    <div class="header-cathegories">
        <a class="cath" href="main.php?type=All">All</a>
        <a class="cath" href="main.php?type=in-ear">In-ear</a>
        <a class="cath" href="main.php?type=over-ear">Over-ear</a>
        <a class="cath" href="main.php?type=wireless">Wireless</a>
    </div>
</header>
<div></div>
<main>
    <div class="order-page">
        <div class="order-info">
            <div class="ord-inf">
                <!--                <hr>-->
                <form action="/php/add_order.php" method="post">
                    <h2>Order Form</h2>
                    <h3>Personal information:</h3>
                    <label class="information-title" for="full_name">Name:</label>
                    <input class="information" type="text" id="full_name" name="full_name" required>

                    <h3>Contacts:</h3>

                    <label class="information-title" for="email">Email:</label>
                    <input class="information" type="email" id="email" name="email" required>

                    <label class="information-title" for="phone">Phone Number:</label>
                    <input class="information" type="tel" id="phone" name="phone" required>

                    <h3>Address</h3>

                    <label class="information-title" for="Country">Country:</label>
                    <input class="information" type="text" id="country" name="country" required>

                    <label class="information-title" for="Country">City/Town:</label>
                    <input class="information" type="text" id="town" name="town" required>

                    <label class="information-title" for="Street">Street:</label>
                    <input class="information" type="text" id="street" name="street" required>

                    <label class="information-title" for="Street">House:</label>
                    <input class="information" type="text" id="house" name="house" required>

                    <label class="information-title" for="Street">Postal code:</label>
                    <input class="information" type="text" id="index" name="index" required>
                    <!--                    <hr>-->
                    <h2>Order Details</h2>
                    <div class="bill">
                        <div class="bill-info">
                            <div class="order-id">User ID</div>
                            <div class="order-num"><?php echo addZeros($user_id)?></div>
                        </div>
                        <div class="bill-info">
                            <div class="total">Total amount</div>
                            <div class="order-price"> <?php echo $price?>$</div>
                        </div>
                    </div>
                    <!--                <hr>-->
                    <button type="submit" class="confirm-order">Confirm Order</button>
                </form>
            </div>
        </div>
    </div>
</main>
<footer class="footer">
    <p>&copy; 2023 All rights reserved.</p>
</footer>
</body>
</html>