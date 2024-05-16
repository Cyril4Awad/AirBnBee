<?php
session_start();

$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "airbnbee";
$conn = "";


$conn = mysqli_connect(
    $db_server,
    $db_user,
    $db_pass,
    $db_name
);

// Check if the user is logged in
if (!isset($_SESSION['userId'])) {
    // Redirect the user or display an error message
    header("Location: login.php");
    exit();
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the listing ID from the form data
    $listingId = $_POST['listing_id'];

    // Query to delete the listing from the database
    $sql = "DELETE FROM listing WHERE ad_id = $listingId";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        // Delete associated images from the folder (implement this logic)

        // Redirect back to the manage listings page or display a success message
        header("Location: manage.php");
        exit();
    } else {
        // Handle the deletion error (e.g., display an error message)
        echo "Error deleting listing: " . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>
