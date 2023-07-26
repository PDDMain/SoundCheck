<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
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
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "example";

    // Create a connection to the database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the INSERT query
    $sql = "INSERT INTO orders (user_id, name, email, phone, address, time) VALUES (NULL, " . $_SESSION['id'] . ", " . $full_name . ", " . $email . ", " . $phone . ", " . $address . ", )";

    if ($conn->query($sql) === TRUE) {
        header("Location: ../personal.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>
