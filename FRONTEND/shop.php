<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!--font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/e-com.css">
    <link rel="stylesheet" href="../assets/css/login.css">
    <link rel="stylesheet" href="style.css">
 

</head>

<body>
    <!--navbar start-->
    <nav class="navbar navbar-expand-lg bg-white">
        <div class="container-fluid">
            <a class="navbar-brand pe-5" href="#">LadyCollection</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">

                    <li class="nav-item">
                        <a class="nav-link active pe-4" href="home.php">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link pe-4" href="shop.php">Shop</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link pe-4" href="#">Blog</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link pe-4" href="#">Contact Us</a>
                    </li>

                    <!-- Cart Icon -->
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fa-solid fa-cart-shopping"></i>
                        </a>
                    </li>
                    <!--user-->
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fa-solid fa-user"></i>
                        </a>
                    </li>
                </ul>
            </div>

        </div>
    </nav>
    <!--navbar end-->

    <!--carousel start-->
    <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>

        <div class="carousel-inner">

            <!-- Slide 1 -->
            <div class="carousel-item active " data-bs-interval="4000">
                <img src="./images/shopping_slider1.jpg" class="d-block w-100" alt="Slide 1">
                <div class="carousel-caption d-none d-md-block text-center">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-lg-8">
                                <p>SPRING / SUMMER COLLECTION 2025</p>
                                <h1>Get up to 30% off</h1>
                                <h1>New Arrivals</h1>
                                <button class="btn0 mt-3 ml-2">SHOP NOW</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="carousel-item" data-bs-interval="4000">
                <img src="./images/shopping_slider1.jpg" class="d-block w-100" alt="Slide 2">
                <div class="carousel-caption d-none d-md-block text-end">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-lg-8">
                                <p>EXCLUSIVE DEALS</p>
                                <h1>Latest Trends 2025</h1>
                                <h1>Shop Now</h1>
                                <button class="btn0 mt-3 ml-2">SHOP NOW</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="carousel-item" data-bs-interval="4000">
                <img src="./images/shopping_slider1.jpg" class="d-block w-100" alt="Slide 3">
                <div class="carousel-caption d-none d-md-block text-center">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-lg-8">
                                <p>WINTER COLLECTION</p>
                                <h1>Stylish & Cozy</h1>
                                <h1>Limited Stock</h1>
                                <button class="btn0 mt-3 ml-2">SHOP NOW</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <!--carousel end-->




    <!-- Footer -->
    <footer class="footer-section bg-dark text-white mt-5 pt-5 pb-4">
        <div class="container">
            <div class="row">

                <!-- Logo + About -->
                <div class="footer-one col-lg-3 col-md-6 col-sm-12 mb-4">
                    <h1>LadyCollection</h1>
                    <p class="pt-3">We provide the best products for the most affordable prices.</p>
                </div>

                <!-- Featured Links -->
                <div class="footer-one col-lg-3 col-md-6 col-sm-12 mb-4">
                    <h5 class="pb-2">Featured</h5>
                    <ul class="footer-links">
                        <li><a href="#">Men</a></li>
                        <li><a href="#">Women</a></li>
                        <li><a href="#">Boys</a></li>
                        <li><a href="#">Girls</a></li>
                    </ul>
                </div>

                <!-- Contact Section -->
                <div class="footer-one col-lg-3 col-md-6 col-sm-12 mb-4">
                    <h5 class="pb-2">Contact Us</h5>
                    <p><strong>Address:</strong> 1234 Street, City</p>
                    <p><strong>Phone:</strong> 123 456 789</p>
                    <p><strong>Email:</strong> info@gmail.com</p>
                </div>

                <!-- Social + Copyright -->
                <div class="footer-one col-lg-3 col-md-6 col-sm-12 mb-4 text-center">
                    <h5 class="pb-2">Follow Us</h5>

                    <div class="footer-social mb-3">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>

                    <p class="copyright">© eCommerce 2025 All Rights Reserved</p>
                </div>

            </div>
        </div>
    </footer>


    <!-- Back to Top Button -->
    <button id="backToTop" class="btn btn-primary">↑</button>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Back to Top functionality
        let btn = document.getElementById('backToTop');
        window.onscroll = function() {
            if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
                btn.style.display = "block";
            } else {
                btn.style.display = "none";
            }
        };
        btn.onclick = function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        };
    </script>
</body>

</html>