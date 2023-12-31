<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $user_id = $_SESSION['id'];

    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "example";

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

    $full_name = $_POST["full_name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $country = $_POST["country"];
    $town = $_POST["town"];
    $street = $_POST["street"];
    $house = $_POST["house"];
    $index = $_POST["index"];
    $address = $country . ", " . $town . ", " . $street . ", " . $house . ", " . $index;

    // Now you can process the form data and save it to the database or perform any other actions

    // For example, you can connect to the database (using the mysqli code from the previous response) and insert the data into a table:
    // Replace these variables with your actual database credentials

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the INSERT query
    $sql = "INSERT INTO orders (id, user_id, name, email, phone, address, price) VALUES (NULL, '$user_id', '$full_name', '$email', '$phone', '$address', '$price')";
    if ($stmt = $conn->prepare($sql)) {

        if ($stmt->execute()) {
            $sql = "DELETE FROM basket WHERE user_id = $user_id";

            if ($conn->query($sql) === TRUE) {
                echo "All items deleted from the basket successfully!";
            } else {
                echo "Error deleting items from the basket: " . $conn->error;
            }
        }
        header("Location: ../profile.php");
    } else {
        echo "Error: " . $sql . "<br>" . $address . "<br>" . $conn->error;

    }
    // Close the database connection
    $conn->close();
}
?>
