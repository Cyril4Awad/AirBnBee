<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "airbnbee";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (!isset($_SESSION['userId'])) {
    return null; // User not logged in, so no rating available
}

// Get the user_id from the session
$user_id = $_SESSION['userId'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $adId = $_POST['ad_id'];
    $checkIn = $_POST['check-in'];
    $checkOut = $_POST['check-out'];
    $guests = $_POST['guest'];

    // Prepare and bind
    $sql = "INSERT INTO rent (user_id, ad_id, check_in, check_out, guests) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt->bind_param("iissi", $user_id, $adId, $checkIn, $checkOut, $guests);

    // Execute the statement
    if ($stmt->execute() === TRUE) {
        echo "Reservation created successfully";
        header("Location: ../home page/main.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
}

$conn->close();
