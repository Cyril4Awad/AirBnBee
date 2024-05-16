<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userId'])) {
    // User is not logged in, return an error response
    echo json_encode(array('success' => false, 'message' => 'User not logged in.'));
    exit();
}

// Check if the listing ID is provided in the POST request
if (!isset($_POST['listingId'])) {
    // Listing ID is missing, return an error response
    echo json_encode(array('success' => false, 'message' => 'Listing ID is missing.'));
    exit();
}

// Sanitize and validate the listing ID
$listingId = filter_var($_POST['listingId'], FILTER_VALIDATE_INT);
if ($listingId === false || $listingId <= 0) {
    // Invalid listing ID, return an error response
    echo json_encode(array('success' => false, 'message' => 'Invalid listing ID.'));
    exit();
}

// Connect to the database
include 'db_connection.php';

// Prepare the SQL statement to toggle the favorite status
$sql = "INSERT INTO favorites (user_id, listing_id) VALUES (?, ?) ON DUPLICATE KEY UPDATE user_id = user_id, listing_id = VALUES(listing_id)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ii", $_SESSION['user_id'], $listingId);

// Execute the SQL statement
if (mysqli_stmt_execute($stmt)) {
    // Database update successful, return a success response
    echo json_encode(array('success' => true));
} else {
    // Database update failed, return an error response
    echo json_encode(array('success' => false, 'message' => 'Database update failed.'));
}

// Close the database connection
mysqli_close($conn);
?>
