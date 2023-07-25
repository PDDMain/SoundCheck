<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="css/error.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;700&display=swap" rel="stylesheet">
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
</header>
<div class="gap"></div>
<div></div>
<main>
    <p class="error_message">
        <?php
        // Display the error message from the URL parameter 'message'
        if (isset($_GET['message'])) {
            echo htmlspecialchars($_GET['message']);
        } else {
            echo 'Unknown error occurred.';
        }
        ?>
    </p>
</main>
<footer class="footer">
    <!-- Footer content goes here -->
    <p>&copy; 2023 All rights reserved.</p>
</footer>
</body>
</html>