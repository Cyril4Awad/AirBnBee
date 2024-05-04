<?php
session_start();
$message = "";

include("hosting.html");

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['publish'])) {
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

        // Process file upload
        if ($_FILES['image']['error'] === 4) {
            echo "<script> alert('Image does not exist'); </script>";
        } else {
            $fileName = $_FILES['image']['name'];
            $fileSize = $_FILES['image']['size'];
            $tmpName = $_FILES['image']['tmp_name'];

            $validImageExtension = ['jpg', 'jpeg', 'png'];
            $imageExtension = explode('.', $fileName);
            $imageExtension = strtolower(end($imageExtension));

            if (!in_array($imageExtension, $validImageExtension)) {
                echo "<script> alert('Invalid image format'); </script>";
            } else if ($fileSize > 1000000) {
                echo "<script> alert('Image size exceeds limit'); </script>";
            } else {
                $newImageName = uniqid() . '.' . $imageExtension;
                $uploadPath = 'img/' . $newImageName;

                if (move_uploaded_file($tmpName, $uploadPath)) {
                    $sql = "INSERT INTO listing (ad_title, description, property_type, size, check_in_host, rent_price, num_bedrooms, num_guests, file_path) 
                            VALUES ('$title', '$description', '$type', '$size', '$check_in_host', '$price', '$bedrooms', '$guests', '$uploadPath')";

                    $sql_address = "INSERT INTO address (country, zip_code, city, street_number) 
                                    VALUES ('$country', '$zip', '$city', '$street')";

                    if (mysqli_query($conn, $sql) && mysqli_query($conn, $sql_address)) {
                        echo "<script> alert('Successfully added'); </script>";
                        echo "<script> document.location.href = 'data.php'; </script>";
                    } else {
                        echo "<script> alert('Error adding record: " . mysqli_error($conn) . "'); </script>";
                    }
                } else {
                    echo "<script> alert('Failed to upload image'); </script>";
                }
            }
        }
    }
    mysqli_close($conn);
}
?>