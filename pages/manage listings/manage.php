<?php
session_start();
$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "airbnbee";
$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['userId'];
$sql = "SELECT * FROM listing WHERE user_id = $userId";
$result = mysqli_query($conn, $sql);

if (!$result) {
    echo "Error: " . mysqli_error($conn);
    exit();
}

$carouselID = 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../home page/style.css" />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="../Home Page/homepage.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="../../assets/images/AirBnBee logo.png" alt="Your Logo" class="logo_img">
                Airbnbee
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../home page/main.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Manage Your Listings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Create Listing/hosting.php">Host Your Ad</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../about us page/aboutus.html">About Us</a>
                    </li>
                </ul>
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="<?php
                                if (isset($_SESSION['firstName'])) {
                                    echo 'width: 50px; height: 50px; margin-right: 50px; border-radius: 50%; border: 1px solid black;';
                                }
                                ?>">
                                <?php
                                    if (isset($_SESSION['firstName'])) {
                                        echo strtoupper(substr($_SESSION['firstName'], 0, 1));
                                    }
                                ?>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#">My profile</a>
                                    <a class="dropdown-item" href="../favorites/favorites.php">Favorites</a>
                                    <a class="dropdown-item" href="../log out/logout.php">Logout</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </nav>

            <div class="container">
                <section id="manage-listings">
                    <div class="container-fluid">
                        <h2 style="text-align: center;">Manage Listings</h2>
                        <div class="row">
                            <?php
                            if (mysqli_num_rows($result) == 0) {
                                echo "<h5 style='margin-top:30px;'>No listings found.</h5>";
                            } else {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $uploadDir = $row['upload_directory'];
                                    if (is_dir($uploadDir)) {
                                        $images = glob($uploadDir . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);
                                        $imageSets = array_chunk($images, 5);
                                        foreach ($imageSets as $imageSet) {
                            ?>
                                            <div class="col-md-6">
                                                <div class="card mb-4">
                                                    <div id="Listing<?php echo $carouselID; ?>Carousel" class="carousel slide" data-bs-ride="carousel">
                                                        <ol class="carousel-indicators">
                                                            <?php
                                                            for ($i = 0; $i < count($imageSet); $i++) {
                                                                $active = ($i === 0) ? 'active' : '';
                                                            ?>
                                                                <li data-target="#Listing<?php echo $carouselID; ?>Carousel" data-slide-to="<?php echo $i; ?>" class="<?php echo $active; ?>"></li>
                                                            <?php } ?>
                                                        </ol>
                                                        <div class="carousel-inner">
                                                            <?php
                                                            foreach ($imageSet as $key => $image) {
                                                                $active = ($key === 0) ? 'active' : '';
                                                            ?>
                                                                <div class="item <?php echo $active; ?>">
                                                                    <img src="<?php echo $image; ?>" alt="Listing Image">
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <a class="left carousel-control" href="#Listing<?php echo $carouselID; ?>Carousel" data-slide="prev">
                                                            <span class="glyphicon glyphicon-chevron-left"></span>
                                                            <span class="sr-only">Previous</span>
                                                        </a>
                                                        <a class="right carousel-control" href="#Listing<?php echo $carouselID; ?>Carousel" data-slide="next">
                                                            <span class="glyphicon glyphicon-chevron-right"></span>
                                                            <span class="sr-only">Next</span>
                                                        </a>
                                                    </div>
                                                    <div class="card-body">
                                                        <h5 class="card-title"><?php echo $row['ad_title']; ?></h5>
                                                        <p class="card-text">Price: $<?php echo $row['rent_price']; ?>/night</p>
                                                        <form id="deleteListingForm" action="delete_listing.php" method="POST">
                                                            <input type="hidden" name="ad_id" value="<?php echo $row['ad_id']; ?>">
                                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this listing?')">Delete Listing</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                            <?php
                                            $carouselID++;
                                        }
                                    }
                                }
                            }
                            ?>
                        </div>
                    </div>
                </section>
            </div>
        </body>
    </html>
