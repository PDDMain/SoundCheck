<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Login</title>
		<link href="css/login_style.css" rel="stylesheet" type="text/css">
		<link href="css/header.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="css/footer.css" type="text/css">
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
	</header>
    <main>
		<div class="login_form">
			<h1>Login</h1>
			<form action="php/authenticate.php" method="post">
				<label for="username">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="username" placeholder="Username" id="username" required>
				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="password" placeholder="Password" id="password" required>
                <?php
                // Display the login error message (if set) from the session
                session_start();
                if (isset($_SESSION['login_error'])) {
                    echo '<div class="error">' . $_SESSION['login_error'] . '</div>';
                    unset($_SESSION['login_error']); // Clear the error message after displaying it
                }
                ?>
				<input type="submit" value="Login">

			</form>
		</div>
        <div class="register">
            <form action="register.php">
                <input type="submit" value="Register">
            </form>
        </div>
    </main>

	<footer class="footer">
		<!-- Footer content goes here -->
		<p>&copy; 2023 All rights reserved.</p>
	</footer>
	</body>





</html>