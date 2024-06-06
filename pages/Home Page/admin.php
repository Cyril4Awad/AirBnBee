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
if (!isset($_SESSION['userId'])) {
    // Redirect user to login page or handle the situation accordingly
    header("Location: ../log in/login.php");
    exit();
}
function is_favorite($ad_id)
{
    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "airbnbee";
    $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

    $user_id = $_SESSION['userId'];

    // Check if the ad_id is a favorite for the user
    $check_sql = "SELECT * FROM favorites WHERE user_id = ? AND ad_id = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("ii", $user_id, $ad_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $is_favorite = $result->num_rows > 0;

    $stmt->close();
    $conn->close();

    return $is_favorite;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Boot Strap CDN link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- Boot Strap script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS Bundle (includes Popper.js) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <!-- Java Script file -->
    <script>
        function changeClass(element) {
            if (element.classList.contains("glyphicon-heart-empty")) {
                element.classList.remove("glyphicon-heart-empty");
                element.classList.add("glyphicon-heart");
            } else {
                element.classList.remove("glyphicon-heart");
                element.classList.add("glyphicon-heart-empty");
            }
        }
    </script>

    <!-- CSS file -->
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="map.css" />

    <title>AirBnBee</title>
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
                        <a class="nav-link active" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Create Listing/hosting.php">Host Your Ad</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../about us page/aboutus.php">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../admin page/dashboard.php">Admin Dashboard</a>
                    </li>
                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="<?php if (isset($_SESSION['firstName'])) {
                                                                                                                                                                                                                                echo 'width: 50px; height: 50px; margin-right: 50px; border-radius: 50%; border: 1px solid black;';
                                                                                                                                                                                                                            } ?>">
                                    <?php if (isset($_SESSION['firstName'])) {
                                        echo strtoupper(substr($_SESSION['firstName'], 0, 1));
                                    } ?>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="../profile/profile.php">My profile</a>
                                    <a class="dropdown-item" href="../favorites/favorites.php">Favorites</a>
                                    <a class="dropdown-item" href="../Manage Listings/manage.php">Manage Listings</a>
                                    <a class="dropdown-item" href="../log out/logout.php">Logout</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </nav>

    <div class="map-container">
        <a href="../../pages/map/map.html">
            <button class="mapbutton">Show map</button>
        </a>
    </div>

    <!-- Carousel Listings -->
    <section id="featured-listings">
        <div class="container-fluid">
            <h2 style="  text-align: center;padding: 20px;margin: 20px;">Featured Listings</h2>

            <?php
            $sql = "SELECT * FROM listing";
            $result = mysqli_query($conn, $sql);

            if (!$result) {
                echo "Error: " . mysqli_error($conn);
                exit();
            }

            $carouselID = 1;
            if (mysqli_num_rows($result) == 0) {
                echo "<h5 style='margin-top:30px;'>No listings found.</h5>";
            } else {
                while ($row = mysqli_fetch_assoc($result)) {
                    // Check if this listing is already a favorite for the user
                    $fav_sql = "SELECT * FROM favorites WHERE user_id = ? AND ad_id = ?";
                    $fav_stmt = $conn->prepare($fav_sql);
                    $fav_stmt->bind_param("ii", $user_id, $ad_id);
                    $fav_stmt->execute();
                    $fav_result = $fav_stmt->get_result();
                    $is_favorite = $fav_result->num_rows > 0;
                    $fav_stmt->close();
                    $uploadDir = $row['upload_directory'];
                    if (is_dir($uploadDir)) {
                        $images = glob($uploadDir . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);
                        $imageSets = array_chunk($images, 5);

                        foreach ($imageSets as $imageSet) {
            ?>

                            <a href="../Listing page/Listing.php?ad_id=<?php echo $row['ad_id']; ?>">
                                <div class="listing">
                                    <div id="Listing<?php echo $carouselID; ?>Carousel" class="carousel slide" data-ride="carousel">
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
                                                    <img src="<?php echo $image; ?>" alt="Listing Image" class="d-block w-100">
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

                                        <a class="carousel-favorite">
                                            <form method="post" action="update_favorite.php">
                                                <button type="submit" style="border: none; background: none; color: inherit;">
                                                    <input type="hidden" name="ad_id" value="<?php echo $row['ad_id']; ?>">
                                                    <span class="glyphicon <?php echo is_favorite($row['ad_id']) ? 'glyphicon-heart' : 'glyphicon-heart-empty'; ?>" role="button" onclick="toggleFavorite(this)"></span>
                                                </button>
                                                <span class="sr-only">Favorite</span>
                                            </form>

                                        </a>
                                    </div>

                                    <h3><?php echo $row['ad_title']; ?></h3>
                                    <span>$<?php echo $row['rent_price']; ?>/night</span>
                                </div>
                            </a>
            <?php
                            $carouselID++;
                        }
                    }
                }
            }
            ?>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-light text-black py-4">
        <div class="container text-center">
            <p>&copy; 2024 Airbnbee. All rights reserved.</p>
        </div>
    </footer>

</body>

</html>