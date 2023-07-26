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
        <div><img class="logo" src="img/logo.jpg"></div>
        <div class="search-container">
            <div class="search">
                <input type="text" placeholder="Search">
                <button class="search-button">Search</button>
            </div>
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
    <div class="gap"></div>
    <div class="header-cathegories">
        <a class="cath" href="#">All</a>
        <a class="cath" href="#">In-ear</a>
        <a class="cath" href="#">Over-ear</a>
        <a class="cath" href="#">Wireless</a>
    </div>
</header>
<div></div>
<main>
    <div class="order-page">
        <div class="order-info">
            <div class="ord-inf">
                <h2>Order Form</h2>
                <!--                <hr>-->
                <form action="php/add_order.php" method="post">
                    <h3>Personal information</h3>
                    <label class="information-title" for="full_name">Name:</label>
                    <input class="information" type="text" id="full_name" name="full_name" required>

                    <h3>Contacts</h3>

                    <label class="information-title" for="email">Email:</label>
                    <input class="information" type="email" id="email" name="email" required>

                    <label class="information-title" for="phone">Phone Number:</label>
                    <input class="information" type="tel" id="phone" name="phone" required>

                    <h3>Address</h3>

                    <label class="information-title" for="Country">Country:</label>
                    <input class="information" type="text" id="country" name="country" required>

                    <label class="information-title" for="Country">City/Town:</label>
                    <input class="information" type="text" id="town" name="country" required>

                    <label class="information-title" for="Street">Street:</label>
                    <input class="information" type="text" id="street" name="country" required>

                    <label class="information-title" for="Street">House:</label>
                    <input class="information" type="text" id="house" name="country" required>

                    <label class="information-title" for="Street">Postal code:</label>
                    <input class="information" type="text" id="index" name="country" required>
                </form>
                <hr>
                <h2>Order Details</h2>
                <div class="bill">
                    <div class="bill-info">
                        <div class="order-id">Order ID</div>
                        <div class="order-num">123456</div>
                    </div>
                    <div class="bill-info">
                        <div class="total">Total amount</div>
                        <div class="order-price"> 10$</div>
                    </div>
                </div>
                <!--                <hr>-->
                <button class="confirm-order">Confirm Order</button>
            </div>
        </div>
    </div>
</main>
<footer class="footer">
    <p>&copy; 2023 All rights reserved.</p>
</footer>
</body>
</html>