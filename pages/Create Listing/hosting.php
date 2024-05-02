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


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection file
    if (isset($_POST['publish'])) {



        // Retrieve form data
        $title = $_POST['title'];
        $description = $_POST['description'];
        $type = $_POST['type'];
        $size = $_POST['size'];
        $price = $_POST['price'];
        $bedrooms = $_POST['bedrooms'];
        $check_in_host = $_POST['host'];
        $guests = $_POST['guests'];

        // Process file upload if needed (not included in this example)

        // Prepare SQL statement to insert data into the database
        $sql = "INSERT INTO listing (ad_title, description, property_type, size, check_in_host, rent_price, num_bedrooms, num_guests) 
            VALUES ('$title', '$description', '$type', '$size', '$check_in_host' ,'$price', '$bedrooms', '$guests')";


        $uploadDir = "../../assets/uploads/"; // Directory where uploaded files will be stored
        $uploadedFiles = [];

        if (!empty($_FILES['images']['name'][0])) {
            $numFiles = count($_FILES['images']['name']);

            for ($i = 0; $i < $numFiles; $i++) {
                $fileName = $_FILES['images']['name'][$i];
                $tempFile = $_FILES['images']['tmp_name'][$i];
                $targetFile = $uploadDir . basename($fileName);

                if (move_uploaded_file($tempFile, $targetFile)) {
                    $uploadedFiles[] = $targetFile;
                } else {
                    echo "Error uploading file $fileName.";
                }
            }
        }

        // Insert file paths into the database
        foreach ($uploadedFiles as $file) {
            $img_sql = "INSERT INTO listing (listing_id, file_path) VALUES ('$listingId', '$file')";
            if (mysqli_query($conn, $img_sql)) {
                echo "Image inserted successfully into database.";
            } else {
                echo "Error inserting image into database: " . mysqli_error($conn);
            }
        }

        $queries = $sql + $img_sql;

        // Execute the SQL statement
        if (mysqli_query($conn, $queries)) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $queries . "<br>" . mysqli_error($conn);
        }

        // Close the database connection
        mysqli_close($conn);
    }
}
