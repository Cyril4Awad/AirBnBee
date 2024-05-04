<?php
session_start();

$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "airbnbee";
$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['publish'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $type = $_POST['type'];
    $size = $_POST['size'];
    $price = $_POST['price'];
    $bedrooms = $_POST['bedrooms'];
    $check_in_host = $_POST['host'];
    $guests = $_POST['guests'];
    $country = $_POST['country'];
    $zip = $_POST['zip'];
    $city = $_POST['city'];
    $street = $_POST['street'];

    // Prepare and bind SQL statement
    $sql = "INSERT INTO listing (ad_title, description, property_type, size, check_in_host, rent_price, num_bedrooms, num_guests, file_path) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssiss", $title, $description, $type, $size, $check_in_host, $price, $bedrooms, $guests, $uploadPath);

        // File upload handling
    if (isset($_FILES['images'])) {
        $fileNames = $_FILES['images']['name'];
        $fileSizes = $_FILES['images']['size'];
        $tmpNames = $_FILES['images']['tmp_name'];

        // Create directory if it doesn't exist
        $uploadDirectory = '../../assets/uploads/';
        if (!file_exists($uploadDirectory)) {
            mkdir($uploadDirectory, 0777, true);
        }

        foreach ($fileNames as $key => $fileName) {
            $validImageExtension = ['jpg', 'jpeg', 'png'];
            $imageExtension = pathinfo($fileName, PATHINFO_EXTENSION);

            if (!in_array($imageExtension, $validImageExtension)) {
                echo "<script> alert('Invalid image format'); </script>";
                exit; // Stop execution if invalid image format
            }

            if ($fileSizes[$key] > 1000000) {
                echo "<script> alert('Image size exceeds limit'); </script>";
                exit; // Stop execution if image size exceeds limit
            }

            $newImageName = uniqid() . '.' . $imageExtension;
            $uploadPath = $uploadDirectory . $newImageName;

            if (!move_uploaded_file($tmpNames[$key], $uploadPath)) {
                echo "<script> alert('Failed to upload image'); </script>";
                exit; // Stop execution if failed to upload image
            }
        }
    }
    // Execute the prepared statement outside the loop
    if (mysqli_stmt_execute($stmt)) {
        echo "<script> alert('Successfully added'); </script>";
        echo "<script> document.location.href = 'data.php'; </script>";
    } else {
        echo "<script> alert('Error adding record: " . mysqli_error($conn) . "'); </script>";
    }

    // Close statement
    mysqli_stmt_close($stmt);
}

// Close connection
mysqli_close($conn);
?>
