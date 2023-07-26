<?php
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

// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'admin';
$DATABASE_PASS = '0f4828da8bb2c1de5036206c7bab79319c3ba671516ca6fe';
$DATABASE_NAME = 'example';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the updated values from the form
    $action = $_POST["action"];
    if ($action === 'logout') {
        header('Location: php/logout.php');
        exit();
    }
}

// We don't have the password or email info stored in sessions, so instead, we can get the results from the database.
$stmt = $con->prepare('SELECT username, password, first_name, second_name, email, phone FROM accounts WHERE id = ?');
// In this case we can use the account ID to get the account info.
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($username, $password, $first_name, $second_name, $email, $phone);
$stmt->fetch();
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the updated values from the form
    $action = $_POST["action"];
    if ($action === 'edit') {
        $username_form = $_POST["username"];
        $first_name_form = $_POST["first_name"];
        $second_name_form = $_POST["second_name"];
        $email_form = $_POST["email"];
        $phone_form = $_POST["phone"];

        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }

        if (empty($username_form) || empty($first_name_form) || empty($second_name_form) || empty($email_form) || ($phone_form === 0)) {
            echo "Error: Please fill in all required fields.";
            exit;
        }

        if (($username !== $username_form) || ($first_name !== $first_name_form) ||
            ($second_name !== $second_name_form) || ($email !== $email_form) || ($phone !== $phone_form)) {

            if ($username !== $username_form) {
                $stmt = $con->prepare("SELECT * FROM accounts WHERE username = ?");
                $stmt->bind_param("s", $username_form);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    echo "Error: The username is already taken.";
                    $stmt->close();
                    $con->close();
                    exit;
                }
            }
            $insert_stmt = $con->prepare("UPDATE accounts SET username = ?, first_name = ?, second_name = ?, email = ?, phone = ? WHERE id = ?");
            $insert_stmt->bind_param("sssssi",$username_form, $first_name_form, $second_name_form, $email_form, $phone_form, $_SESSION['id']);
            if ($insert_stmt->execute()) {
                // Data inserted successfully
                $username = $username_form;
                $first_name = $first_name_form;
                $second_name = $second_name_form;
                $email = $email_form;
                $phone = $phone_form;
            } else {
                // Error occurred while inserting data
                echo "Error: " . $insert_stmt->error;
                exit();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="css/user-style.css">
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
    <div class="header-cathegories">
        <a class="cath" href="main.php?type=All">All</a>
        <a class="cath" href="main.php?type=in-ear">In-ear</a>
        <a class="cath" href="main.php?type=over-ear">Over-ear</a>
        <a class="cath" href="main.php?type=wireless">Wireless</a>
    </div>
</header>
<div></div>
<main>
    <div class="user-page">
        <div class="user-info">
            <form class="us-inf" method="post">
                <div class="my-info">My information</div>
                <div class="information-title">Username</div>
                                <input class="information" contenteditable="false" type="text" name="username"
                                       value="<?php echo $username; ?>">
                <div class="information-title">First name</div>
                <input class="information" contenteditable="true" type="text" name="first_name"
                       value="<?php echo $first_name; ?>">
                <!--        <hr>-->
                <div class="information-title">Last name</div>
                <input class="information" contenteditable="true" type="text" name="second_name"
                       value="<?php echo $second_name; ?>">
                <!--        <hr>-->
                <!--        <hr>-->
                <div class="information-title">Email</div>
                <input class="information" contenteditable="true" type="text" name="email"
                       value="<?php echo $email; ?>">
                <!--        <hr>-->
                <div class="information-title">Phone number</div>
                <input class="information" contenteditable="true" type="text" name="phone"
                       value="<?php echo $phone; ?>">
                <button type="submit" name="action" value="edit" class="edit">Confirm changes</button>
                <button name="action" value="logout" class="logout">Log out</button>
                <button name="action" value="logout" class="logout">Delete account</button>
            </form>
        </div>

        <div class="orders-info">
            <div class="orders-title">Order history</div>

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
            $query = "SELECT * FROM orders WHERE user_id = $user_id ORDER BY time DESC";

            $result = $mysqli->query($query);

            // Display the goods in the basket
            if ($result->num_rows > 0) {
                if ($row = $result->fetch_assoc()) {
                    echo '<div class="order-info">';
                    echo '<div class="order-id">Order ID: ' . addZeros($row['id']) . '</div>';
                    echo '<div class="order-date">Date: ' . $row['time'] . '</div>';
                    echo '<div class="order-price"> ' . $row['price'] . '$</div>';
                    echo '</div>';
                }
                while ($row = $result->fetch_assoc()) {
                    echo '<hr>';
                    echo '<div class="order-info">';
                    echo '<div class="order-id">Order ID: ' . addZeros($row['id']) . '</div>';
                    echo '<div class="order-date">Date: ' . $row['time'] . '</div>';
                    echo '<div class="order-price"> ' . $row['price'] . '$</div>';
                    echo '</div>';
                }
            }

            // Close the database connection
            $mysqli->close();
            ?>
        </div>
    </div>
</main>
<footer class="footer">
    <p>&copy; 2023 All rights reserved.</p>
</footer>
</body>
</html>