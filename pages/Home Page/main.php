<?php
session_start();
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

    <!-- Java Script file -->
    <script src="../Home Page/homepage.js"></script>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

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
                        <a class="nav-link" href="../Create Listing/hosting.html" target="_blank">Host Your Ad</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="../about us page/aboutus.html">About Us</a>
                    </li>
                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">
                        <ul class="navbar-nav">
                            <!-- Avatar -->
                            <li class="nav-item dropdown">
                               
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" 
                                id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" 
                                aria-haspopup="true" aria-expanded="false" 
                                style="<?php
                            // Apply inline styles based on the condition
                            if (isset($_SESSION['firstName'])) {
                            echo 'width: 50px; height: 50px; margin-right: 50px; border-radius: 50%; border: 1px solid black;';
                                                                }
                                                         ?>">
                                    <?php
                                    // Display the first letter of the user's first name
                                    if (isset($_SESSION['firstName'])) {
                                        echo strtoupper(substr($_SESSION['firstName'], 0, 1));
                                    }
                                    ?>
                                </a>



                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#">My profile</a>
                                    <a class="dropdown-item" href="#">Settings</a>
                                    <a class="dropdown-item" href="logout.php">Logout</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>

    </nav>

    <div>
        <div class="map-container">
            <a href="../../pages/map/map.html">
                <button class="mapbutton"> Show map</button>
            </a>
        </div>

        <!-- Carousel Listings  -->
        <section id="featured-listings">
            <div class="container-fluid">
                <h2>Featured Listings</h2>

                <a href="../Listing page/Listingpage.html">
                    <div class="listing">
                        <div id="Listing1Carousel" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#Listing1Carousel" data-slide-to="0" class="active"></li>
                                <li data-target="#Listing1Carousel" data-slide-to="1"></li>
                                <li data-target="#Listing1Carousel" data-slide-to="2"></li>
                                <li data-target="#Listing1Carousel" data-slide-to="3"></li>
                                <li data-target="#Listing1Carousel" data-slide-to="4"></li>
                                <li data-target="#Listing1Carousel" data-slide-to="5  "></li>
                            </ol>

                            <div class="carousel-inner">
                                <div class="item active">
                                    <img src="../../assets/images/Listing 1/Image 1.jpg" alt="New york">
                                </div>


                                <div class="item">
                                    <img src="../../assets/images/Listing 1/Image 2.jpg" alt="New york">
                                </div>

                                <div class="item">
                                    <img src="../../assets/images/Listing 1/Image 3.jpg" alt="New york">
                                </div>

                                <div class="item">
                                    <img src="../../assets/images/Listing 1/Image 4.jpg" alt="New york">
                                </div>

                                <div class="item">
                                    <img src="../../assets/images/Listing 1/Image 5.jpg" alt="New york">
                                </div>

                                <div class="item">
                                    <img src="../../assets/images/Listing 1/Image 6.jpg" alt="New york">
                                </div>

                            </div>

                            <!-- Left and right controls -->
                            <a class="left carousel-control" href="#Listing1Carousel" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left"></span>
                                <span class="sr-only">Previous</span>
                            </a>

                            <a class="right carousel-control" href="#Listing1Carousel" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right"></span>
                                <span class="sr-only">Next</span>
                            </a>

                            <!-- Favorite Icon -->
                            <a class="carousel-favorite">
                                <span class="glyphicon glyphicon-heart-empty" onclick="changeClass(this)"></span>
                                <span class="sr-only">Favorite</span>
                            </a>

                        </div>


                        <h3>Listing 1</h3>
                        <p>1,013 Kilometers away <br> Apr 14-19</p>
                        <span>$100/night</span>
                    </div>
                </a>

                <!-- beginning of the listing -->
                <div class="listing">
                    <a href="#">
                        <div id="Listing2Carousel" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#Listing2Carousel" data-slide-to="0" class="active"></li>
                                <li data-target="#Listing2Carousel" data-slide-to="1"></li>
                                <li data-target="#Listing2Carousel" data-slide-to="2"></li>
                            </ol>

                            <div class="carousel-inner">
                                <div class="item active">
                                    <img src="../../assets/images/Listing 2/Image 7.jpg" alt="Los Angeles">
                                </div>

                                <div class="item">
                                    <img src="../../assets/images/Listing 2/Image 8.jpg" alt="Chicago">
                                </div>

                                <div class="item">
                                    <img src="../../assets/images/Listing 2/Image 9.jpg" alt="New york">
                                </div>
                            </div>

                            <!-- Left and right controls -->
                            <a class="left carousel-control" href="#Listing2Carousel" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left"></span>
                                <span class="sr-only">Previous</span>
                            </a>

                            <a class="right carousel-control" href="#Listing2Carousel" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right"></span>
                                <span class="sr-only">Next</span>
                            </a>

                            <!-- Favorite Icon -->
                            <a class="carousel-favorite">
                                <span class="glyphicon glyphicon-heart-empty" onclick="changeClass(this)"></span>
                                <span class="sr-only">Favorite</span>
                            </a>

                        </div>
                        <h3>Listing 2</h3>
                        <p>1,798 Kilometers away <br> Apr 14-19</p>
                        <span>$100/night</span>
                    </a>
                </div>

                <!-- end of the listing -->
                <!-- beginning of the listing -->
                <div class="listing">
                    <a href="#">
                        <div id="Listing3Carousel" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#Listing3Carousel" data-slide-to="0" class="active"></li>
                                <li data-target="#Listing3Carousel" data-slide-to="1"></li>
                                <li data-target="#Listing3Carousel" data-slide-to="2"></li>
                            </ol>

                            <div class="carousel-inner">
                                <div class="item active">
                                    <img src="../../assets/images/Listing 3/Image 10.jpg" alt="Los Angeles">
                                </div>

                                <div class="item">
                                    <img src="../../assets/images/Listing 3/Image 11.jpg" alt="Chicago">
                                </div>

                                <div class="item">
                                    <img src="../../assets/images/Listing 3/Image 12.jpg" alt="New york">
                                </div>
                            </div>

                            <!-- Left and right controls -->
                            <a class="left carousel-control" href="#Listing3Carousel" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left"></span>
                                <span class="sr-only">Previous</span>
                            </a>

                            <a class="right carousel-control" href="#Listing3Carousel" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right"></span>
                                <span class="sr-only">Next</span>
                            </a>

                            <!-- Favorite Icon -->
                            <a class="carousel-favorite">
                                <span class="glyphicon glyphicon-heart-empty" onclick="changeClass(this)"></span>
                                <span class="sr-only">Favorite</span>
                            </a>

                        </div>

                        <h3>Listing 3</h3>
                        <p>972 Kilometers away <br> Apr 8-13</p>
                        <span>$200/night</span>
                    </a>
                </div>

                <!-- end of the listing -->

                <!-- beginning of the listing -->
                <div class="listing">
                    <a href="#">
                        <div id="Listing4Carousel" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#Listing4Carousel" data-slide-to="0" class="active"></li>
                                <li data-target="#Listing4Carousel" data-slide-to="1"></li>
                                <li data-target="#Listing4Carousel" data-slide-to="2"></li>
                            </ol>

                            <div class="carousel-inner">
                                <div class="item active">
                                    <img src="../../assets/images/Listing 4/Image 14.jpg" alt="Los Angeles">
                                </div>

                                <div class="item">
                                    <img src="../../assets/images/Listing 4/Image 15.jpg" alt="Chicago">
                                </div>

                                <div class="item">
                                    <img src="../../assets/images/Listing 4/Image 16.jpg" alt="New york">
                                </div>
                            </div>

                            <!-- Left and right controls -->
                            <a class="left carousel-control" href="#Listing4Carousel" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left"></span>
                                <span class="sr-only">Previous</span>
                            </a>

                            <a class="right carousel-control" href="#Listing4Carousel" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right"></span>
                                <span class="sr-only">Next</span>
                            </a>

                            <!-- Favorite Icon -->
                            <a class="carousel-favorite">
                                <span class="glyphicon glyphicon-heart-empty" onclick="changeClass(this)"></span>
                                <span class="sr-only">Favorite</span>
                            </a>

                        </div>

                        <h3>Listing 4</h3>
                        <p>1,465 Kilometers away <br> May 15-20</p>
                        <span>$180/night</span>
                    </a>
                </div>
                <!-- end of the listing -->

                <!-- beginning of the listing -->
                <div class="listing">
                    <a href="#">
                        <div id="Listing5Carousel" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#Listing5Carousel" data-slide-to="0" class="active"></li>
                                <li data-target="#Listing5Carousel" data-slide-to="1"></li>
                                <li data-target="#Listing5Carousel" data-slide-to="2"></li>
                            </ol>

                            <div class="carousel-inner">
                                <div class="item active">
                                    <img src="../../assets/images/Listing 5/Image 17.jpg" alt="Los Angeles">
                                </div>

                                <div class="item">
                                    <img src="../../assets/images/Listing 5/Image 18.jpg" alt="Chicago">
                                </div>

                                <div class="item">
                                    <img src="../../assets/images/Listing 5/Image 19.jpg" alt="New york">
                                </div>
                            </div>

                            <!-- Left and right controls -->
                            <a class="left carousel-control" href="#Listing5Carousel" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left"></span>
                                <span class="sr-only">Previous</span>
                            </a>

                            <a class="right carousel-control" href="#Listing5Carousel" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right"></span>
                                <span class="sr-only">Next</span>
                            </a>

                            <!-- Favorite Icon -->
                            <a class="carousel-favorite">
                                <span class="glyphicon glyphicon-heart-empty" onclick="changeClass(this)"></span>
                                <span class="sr-only">Favorite</span>
                            </a>

                        </div>

                        <h3>Listing 5</h3>
                        <p>276 Kilometers away <br> May 15-20</p>
                        <span>$180/night</span>
                    </a>
                </div>
                <!-- end of the listing -->
            </div>

        </section>
    </div>

</body>

</html>