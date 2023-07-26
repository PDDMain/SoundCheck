<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="css/first_page_style.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" rel="stylesheet" href="css/header.css">
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
                <li><a href="#">
                        <div class="user-container">
                            <img class="user" src="img/user_icon.jpg">
                            <img class="user-hover" src="img/user_icon_hover.jpg">
                        </div>
                    </a></li>
                <li><a href="#">
                        <div class="cart-container">
                            <img class="cart" src="img/shopping_cart_icon.jpg">
                            <img class="cart-hover" src="img/shopping_cart_icon_hover.jpg">
                        </div>
                    </a></li>
            </ul>
        </nav>
    </div>
    <div class="header-cathegories">
        <a class="cath" href="#">All</a>
        <a class="cath" href="#">In-ear</a>
        <a class="cath" href="#">Over-ear</a>
        <a class="cath" href="#">Wireless</a>
    </div>
</header>
<main>

    <a href="#">
        <img class="welcome" src="img/welcome.jpg">
    </a>

    <form action="php/send_message.php" method="post" class="review_form">
        <label for="new_review" class="leave_review">Leave your review here</label><br>
        <textarea id="new_review" name="review" rows="8" cols="50"></textarea><br>
        <input class="send_review" type="submit" value="Send">
    </form>

    <?php
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

    // Retrieve the user ID from the session
    $user_id = $_SESSION['id'];
    // Fetch the goods from the database that are in the user's basket
    $query = "SELECT * FROM messages ORDER BY time DESC";

    $result = $mysqli->query($query);

    // Display the goods in the basket
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $query = "SELECT username FROM accounts WHERE id = " . $row['user_id'];
            $result1 = $mysqli->query($query);
            $user = $result1->fetch_assoc();

            echo '<div class="review_info">';
            echo '<h2 class="userid"> ' . $user['username'] . ' </h2>';
            echo '<label class="info"> ' . $row['time'] . '</label>';
            echo '<hr>';
            echo '<p class="review_text">' . $row['text'] . '</p>';
            echo '</div>';
        }
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
