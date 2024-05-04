<?php

session_start();
$message = "";


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

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    if($_FILES['image']['error'] === 4){
        echo
        "<script> alert('Image Does Not Exist'); </script>";
    }
    else{
        $fileName = $_FILES['image']['name'];
        $fileSize = $_FILES['image']['size'];
        $tmpName = $_FILES['image']['tmp_name'];
    
        $validImageExtension = ['jpg', 'jpeg', 'png'];
        $imageExtension = explode('.' , $fileName);
        $imageExtension = strtolower(end($imageExtension));

        if(!in_array($imageExtension, $validImageExtension)){
            echo
            "<script> alert('Image Does Not Exist'); </script>";
        }
        else if ($fileSize > 1000000){
            echo
            "<script> alert('Image Does Not Exist'); </script>";
        }
        else{
            $newImageName = uniqid();
            $newImageName .= '.' . $imageExtension;

            move_uploaded_file($tmpName, 'img/' . $newImageName);
            $query = "INSERT INTO listing (listing_name , file_path)
            VALUES('$name' , '$newImageName')";
            mysqli_query($conn, $query);
            echo
            "<script>
                alert('Successfully Added');
               
                </script>";

        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="" method="post" enctype="multipart/form-data">

    <label for="name">Name</label><span style="color: red !important; display: inline; float: none;">*</span>
       <input type="text" name="name" id="name" required value=""/><br>
        <label for="image" >Upload Images</label><span style="color: red !important; display: inline; float: none;">*</span>
        <input type="file" id="image" accept=" .jpg, .jpeg, .png" name="image" value="">
        <button type="submit" name="submit" >Submit</button>

    </form>
</body>

</html>