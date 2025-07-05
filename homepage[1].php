<?php
session_start();

// Logika
if (!isset($_SESSION['username'])) {
    header("Location: index.php"); // Redirect ke index.php jika belum login
    exit;
}

// Ambil username dari sesi setelah dipastikan sudah login
$current_username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drivewise</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta8PUbW+FgW+dYGsJSSzBljoxJTY4H7z/DbSYQcOVDh/g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css\style.css">


        <style>
        :root {
            --primary-orange: #F89B2B; /* Warna oranye utama */
            --primary-blue: #2E709E;    /* Warna biru utama */
            --dark-blue: #1E5C8A;       /* Biru gelap untuk hover, dll. */
            --light-gray: #F3F4F6;      /* Warna background terang */
            --text-dark: #333;
            --text-light: #666;
            --section-bg-light: #F9FAFB;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--text-dark);
            background-color: #fff; /* Default background putih */
        }

        /* --- Global Styles --- */
        .container-fluid-custom {
            padding-left: 5%; /* Padding samping untuk konten utama */
            padding-right: 5%;
        }

        /* --- Navbar --- */
        .navbar-brand img {
            height: 40px; /* Atur tinggi logo */
        }
        .navbar-nav .nav-link {
            color: var(--text-dark) !important;
            font-weight: 500;
            margin-right: 20px;
        }
        .navbar-nav .nav-link:hover {
            color: var(--primary-orange) !important;
        }
        .btn-get-car {
            background-color: var(--primary-orange);
            color: white;
            border-radius: 8px;
            padding: 10px 25px;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }
        .btn-get-car:hover {
            background-color: #E08722; /* Sedikit lebih gelap */
            color: white;
        }
        .navbar {
            padding-top: 20px;
            padding-bottom: 20px;
        }


        /* --- Hero Section --- */
        .hero-section {
            background-color: white;
            color: #2E709E;
            padding: 80px 0 0; /* Padding atas dan bawah */
            position: relative;
            overflow: hidden; /* Penting untuk gambar mobil */
            display: flex;
            align-items: center;
        }
        .hero-content h1 {
            font-size: clamp(2.5rem, 4vw + 1rem, 4.5rem); /* Responsive font size */
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 25px;
        }
        .hero-content p {
            font-size: 1.15rem;
            margin-bottom: 30px;
            line-height: 1.6;
        }
        .hero-image-container {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: flex-end; /* Posisikan mobil di bagian bawah */
            height: 100%; /* Agar gambar bisa mengisi tinggi container */
        }
        .hero-image {
            max-width: 100%;
            height: auto;
            position: relative; /* Agar bisa diatur posisinya relatif terhadap container */
            bottom: -5px; /* Sedikit menjorok ke bawah agar rata dengan garis bawah */
            right: -20px; /* Sedikit menjorok ke kanan */
            filter: drop-shadow(0 15px 20px rgba(0,0,0,0.3)); /* Bayangan mobil */
        }

        /* Hero Action Buttons */
        .hero-actions .btn-primary-outline {
            background-color: #E6A43B;
            border: #E6A43B;
            color: white;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-right: 15px;
        }
        .hero-actions .btn-primary-outline:hover {
            background-color: #E6A43B;
            color: var(--primary-orange);
        }
        .hero-actions .btn-link-white {
            color: #E6A43B;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            display: inline-flex;
            align-items: center;
        }
        .hero-actions .btn-link-white i {
            margin-left: 8px;
            transition: margin-left 0.3s ease;
        }
        .hero-actions .btn-link-white:hover i {
            margin-left: 12px;
        }

        /* Brands Logo */
        .brands-logo {
            background-color: white;
            padding-bottom: 100px; /* Padding bawah untuk area logo */
            padding-top: 30px;
        }
        .brands-logo img {
            max-height: 40px;
        }
        .brands-logo img:hover {
            opacity: 1;
        }

        /* --- Stats Section --- */
        .stats-section {
            background-color: var(--primary-orange);
            color: white;
            padding: 20px 0;
            border-top-left-radius: 100px; /* Bentuk melengkung kiri atas */
            border-top-right-radius: 100px; /* Bentuk melengkung kanan atas */
            margin-top: -50px; /* Menarik ke atas menutupi bagian bawah hero */
            position: relative;
            z-index: 1;
        }
        .stat-item {
            text-align: center;
        }
        .stat-item h3 {
            font-size: clamp(2rem, 3vw + 1rem, 3.5rem);
            font-weight: 800;
            margin-bottom: 5px;
        }
        .stat-item p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        /* --- Choose Your Next Car Section --- */
        .choose-car-section {
            padding: 80px 0;
            background-color: var(--section-bg-light);
            text-align: center;
        }
        .choose-car-section h2 {
            font-size: clamp(2rem, 3vw + 1rem, 3.5rem);
            font-weight: 700;
            margin-bottom: 60px;
        }
        .car-card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            margin-bottom: 30px;
            overflow: hidden;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .car-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.12);
        }
        .car-card img {
            max-width: 100%;
            height: 180px; /* Tinggi gambar mobil di kartu */
            object-fit: contain; /* Memastikan gambar sesuai tanpa terdistorsi */
            padding: 20px 10px;
        }
        .car-card-body {
            padding: 20px;
            background-color: var(--primary-blue);
            color: white;
        }
        .car-card-body h5 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 10px;
        }
        .car-card-body p {
            font-size: 1.1rem;
            font-weight: 500;
            margin-bottom: 20px;
        }
        .car-card-body .btn-book-now {
            background-color: #fff;
            color: var(--primary-blue);
            border-radius: 5px;
            padding: 8px 25px;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }
        .car-card-body .btn-book-now:hover {
            background-color: var(--light-gray);
        }

        /* --- Drivewise Advantage Section --- */
        .advantage-section {
            background-color: #fff;
            padding: 80px 0;
        }
        .advantage-section h2 {
            font-size: clamp(2rem, 3vw + 1rem, 3.5rem);
            font-weight: 700;
            margin-bottom: 40px;
            color: var(--primary-orange);
            text-align: center;
        }
        .advantage-section p {
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        .advantage-section .btn-explore {
            background-color: var(--primary-orange);
            color: white;
            padding: 12px 35px;
            border-radius: 8px;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }
        .advantage-section .btn-explore:hover {
            background-color: #E08722;
        }
        .advantage-image {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        /* --- Beyond Rentals Section --- */
        .beyond-rentals-section {
            background-color: var(--section-bg-light);
            padding: 80px 0;
        }
        .beyond-rentals-section h2 {
            font-size: clamp(2rem, 3vw + 1rem, 3.5rem);
            font-weight: 700;
            margin-bottom: 30px;
            color: var(--dark-blue);
        }
        .beyond-rentals-section p {
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        .beyond-rentals-section .btn-explore-blue {
            background-color: var(--primary-blue);
            color: white;
            padding: 12px 35px;
            border-radius: 8px;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }
        .beyond-rentals-section .btn-explore-blue:hover {
            background-color: var(--dark-blue);
        }
        .beyond-rentals-image {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        /* --- Reviews Section --- */
        .reviews-section {
            padding: 80px 0;
            text-align: center;
            background-color: #fff;
        }
        .reviews-section h2 {
            font-size: clamp(2rem, 3vw + 1rem, 3.5rem);
            font-weight: 700;
            margin-bottom: 60px;
        }
        .review-card {
            background-color: var(--primary-blue);
            color: white;
            padding: 30px;
            border-radius: 10px;
            text-align: left;
            margin-bottom: 30px;
            height: 100%; /* Memastikan tinggi kartu sama */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .review-card p {
            font-size: 1rem;
            line-height: 1.5;
            margin-bottom: 20px;
        }
        .reviewer-info {
            display: flex;
            align-items: center;
            margin-top: auto; /* Dorong ke bawah */
        }
        .reviewer-info img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 15px;
            border: 2px solid white;
        }
        .reviewer-name h5 {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 600;
        }
        .reviewer-name span {
            font-size: 0.9em;
            opacity: 0.8;
        }
        .btn-see-more-reviews {
            background-color: var(--primary-orange);
            color: white;
            padding: 12px 35px;
            border-radius: 8px;
            font-weight: 600;
            transition: background-color 0.3s ease;
            margin-top: 30px;
        }
        .btn-see-more-reviews:hover {
            background-color: #E08722;
        }

        /* --- Footer --- */
        .footer-section {
            background-color: var(--primary-orange);
            color: white;
            padding: 60px 0 20px;
        }
        .footer-logo img {
            height: 50px;
            filter: brightness(0) invert(1); /* Membuat logo putih */
            margin-bottom: 20px;
        }
        .footer-section h5 {
            font-weight: 600;
            margin-bottom: 20px;
            font-size: 1.2rem;
        }
        .footer-section ul {
            list-style: none;
            padding: 0;
        }
        .footer-section ul li a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            line-height: 2.2;
            transition: color 0.3s ease;
        }
        .footer-section ul li a:hover {
            color: white;
        }
        .footer-social-icons a {
            color: white;
            font-size: 1.5rem;
            margin-right: 15px;
            transition: opacity 0.3s ease;
        }
        .footer-social-icons a:hover {
            opacity: 0.8;
        }
        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            padding-top: 20px;
            margin-top: 40px;
            font-size: 0.9em;
            text-align: center;
            opacity: 0.8;
        }
        .footer-bottom a {
            color: white;
            text-decoration: underline;
        }

        /* Responsive Adjustments */
        @media (max-width: 991.98px) { /* Tablet and smaller */
            .hero-section {
                text-align: center;
                padding-top: 50px;
                padding-bottom: 50px;
            }
            .hero-image-container {
                margin-top: 40px;
                justify-content: center; /* Tengahkan gambar di mobile */
            }
            .hero-image {
                right: 0; /* Reset right position */
                bottom: -10px;
            }
            .stats-section {
                border-top-left-radius: 50px;
                border-top-right-radius: 50px;
                margin-top: -30px;
            }
            .navbar-nav {
                text-align: center;
            }
            .navbar-nav .nav-link {
                margin-right: 0;
            }
            .navbar-collapse {
                background-color: var(--primary-orange);
                padding: 20px;
                border-radius: 10px;
                margin-top: 10px;
            }
            .btn-get-car {
                width: 100%;
                margin-top: 15px;
            }
        }

        @media (max-width: 767.98px) { /* Mobile */
            .stats-section {
                border-top-left-radius: 30px;
                border-top-right-radius: 30px;
                margin-top: -20px;
            }
            .stat-item {
                margin-bottom: 30px;
            }
            .choose-car-section h2,
            .advantage-section h2,
            .beyond-rentals-section h2,
            .reviews-section h2 {
                font-size: 2rem;
            }
            .footer-section .col-md-3 {
                margin-bottom: 30px;
            }
        }

    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg bg-white sticky-top shadow-sm container-fluid-custom">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="assets/Logo - Drivewise.png" alt="Drivewise Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Homepage</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Our Facility</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#choose-car">Choose Your Car</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Review</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Reservation</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#choose-car">Lihat Mobil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                    </ul>
                <a href="homepage.php" class="btn btn-get-car ms-lg-3">Halo, <?php echo htmlspecialchars($current_username); ?></a>
            </div>
        </div>
    </nav>

    <section class="hero-section">
        <div class="container-fluid container-fluid-custom">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-content">
                        <h1>Explore the freedom on car rental with <strong>Drivewise</strong>.</h1>
                        <p>Whether you're planning a road trip, need a reliable vehicle for a business venture, or simply want to explore the city in style, our car rental service is here for you.</p>
                        <div class="hero-actions">
                            <a href="#choose-car" class="btn btn-primary-outline">Get your car today</a>
                            <a href="#choose-car" class="btn-link-white">See all cars <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-flex hero-image-container">
                    <img src="assets/hero-car.png" alt="Red Sports Car" class="hero-image">
                </div>
            </div>
        </div>
    </section>

    <section class="brands-logo">
        <div class="container-fluid container-fluid-custom">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto"><img src="assets/brands/audi.png" alt="Audi"></div>
                <div class="col-auto"><img src="assets/brands/jeep.png" alt="Jeep"></div>
                <div class="col-auto"><img src="assets/brands/opel.png" alt="Opel"></div>
                <div class="col-auto"><img src="assets/brands/dacia.png" alt="Dacia"></div>
                <div class="col-auto"><img src="assets/brands/renault.png" alt="Renault"></div>
                <div class="col-auto"><img src="assets/brands/mercedes-benz.png" alt="Mercedes-Benz"></div>
                <div class="col-auto"><img src="assets/brands/hyundai.png" alt="Hyundai"></div>
                <div class="col-auto"><img src="assets/brands/land-rover.png" alt="Land Rover"></div>
            </div>
        </div>
    </section>

    <section class="stats-section">
        <div class="container-fluid container-fluid-custom">
            <div class="row justify-content-center text-center">
                <div class="col-md-3 col-6 stat-item">
                    <h3>450+</h3>
                    <p>Cars</p>
                </div>
                <div class="col-md-3 col-6 stat-item">
                    <h3>90+</h3>
                    <p>Sales Experts</p>
                </div>
                <div class="col-md-3 col-6 stat-item">
                    <h3>120+</h3>
                    <p>Pickup Locations</p>
                </div>
                <div class="col-md-3 col-6 stat-item">
                    <h3>4650+</h3>
                    <p>Happy Customers</p>
                </div>
            </div>
        </div>
    </section>

    <section class="choose-car-section" id="choose-car">
        <div class="container-fluid container-fluid-custom">
            <h2>Choose Your Next Car</h2>
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6">
                    <div class="car-card">
                        <img src="assets/cars/ford-fiesta.png" alt="Ford Fiesta">
                        <div class="car-card-body">
                            <h5>Ford Fiesta</h5>
                            <p>From $20</p>
                            <a href="booking.php" class="btn btn-book-now">Book now</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="car-card">
                        <img src="assets/cars/bmw-m2.png" alt="BMW M2">
                        <div class="car-card-body">
                            <h5>Bmw M2</h5>
                            <p>From $80</p>
                            <a href="booking.php" class="btn btn-book-now">Book now</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="car-card">
                        <img src="assets/cars/camaro-ss.png" alt="Camaro SS">
                        <div class="car-card-body">
                            <h5>Camaro SS</h5>
                            <p>From $120</p>
                            <a href="booking.php" class="btn btn-book-now">Book now</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="car-card">
                        <img src="assets/cars/ford-fiesta.png" alt="Ford Fiesta">
                        <div class="car-card-body">
                            <h5>Ford Fiesta</h5>
                            <p>From $20</p>
                            <a href="booking.php" class="btn btn-book-now">Book now</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="car-card">
                        <img src="assets/cars/bmw-m2.png" alt="BMW M2">
                        <div class="car-card-body">
                            <h5>Bmw M2</h5>
                            <p>From $80</p>
                            <a href="booking.php" class="btn btn-book-now">Book now</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="car-card">
                        <img src="assets/cars/camaro-ss.png" alt="Camaro SS">
                        <div class="car-card-body">
                            <h5>Camaro SS</h5>
                            <p>From $120</p>
                            <a href="booking.php" class="btn btn-book-now">Book now</a>
                        </div>
                    </div>
                </div>
                   <div class="col-lg-4 col-md-6">
                    <div class="car-card">
                        <img src="assets/cars/ford-fiesta.png" alt="Ford Fiesta">
                        <div class="car-card-body">
                            <h5>Ford Fiesta</h5>
                            <p>From $20</p>
                            <a href="booking.php" class="btn btn-book-now">Book now</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="car-card">
                        <img src="assets/cars/bmw-m2.png" alt="BMW M2">
                        <div class="car-card-body">
                            <h5>Bmw M2</h5>
                            <p>From $80</p>
                            <a href="booking.php" class="btn btn-book-now">Book now</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="car-card">
                        <img src="assets/cars/camaro-ss.png" alt="Camaro SS">
                        <div class="car-card-body">
                            <h5>Camaro SS</h5>
                            <p>From $120</p>
                            <a href="booking.php" class="btn btn-book-now">Book now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="advantage-section">
        <div class="container-fluid container-fluid-custom">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h2 class="text-start">Unleash your journey: <br>The Drivewise Advantage</h2>
                    <p>Immerse yourself in a world of possibilities with our extensive range of vehicles, competitive pricing, and unparalleled customer service. We ensure every aspect of your rental experience is seamless, convenient, and tailored to your needs.</p>
                    <a href="#choose-car" class="btn btn-explore">Explore the possibilities</a>
                </div>
                <div class="col-lg-6 text-center text-lg-end mt-4 mt-lg-0">
                    <img src="assets/advantage-car-1.png" alt="Drivewise Advantage Car" class="advantage-image">
                </div>
            </div>
        </div>
    </section>

    <section class="beyond-rentals-section">
        <div class="container-fluid container-fluid-custom">
            <div class="row align-items-center flex-row-reverse">
                <div class="col-lg-6">
                    <h2 class="text-start">Beyond Rentals, Building Memories</h2>
                    <p>We are more than just a car rental service. We strive to be your trusted companion in crafting unforgettable journeys. Our commitment extends beyond providing reliable vehicles to ensuring your entire journey not only comfortable but also enriching and unforgettable.</p>
                    <a href="#choose-car" class="btn btn-explore-blue">Book your next trip</a>
                </div>
                <div class="col-lg-6 text-center text-lg-start mt-4 mt-lg-0">
                    <img src="assets/advantage-car-2.png" alt="Beyond Rentals Car" class="beyond-rentals-image">
                </div>
            </div>
        </div>
    </section>

    <section class="reviews-section">
        <div class="container-fluid container-fluid-custom">
            <h2>Reviews from our beloved clients</h2>
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6">
                    <div class="review-card">
                        <p>"Improving selection of vehicles and customer service, but this one stands out. Definitely Recommend it."</p>
                        <div class="reviewer-info">
                            <img src="assets/reviews/john-doe.png" alt="John Doe">
                            <div class="reviewer-name">
                                <h5>Maulany Citra</h5>
                                <span>Google Reviews</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="review-card">
                        <p>"From the moment I picked up my car, everything was smooth and efficient. The car was spotless."</p>
                        <div class="reviewer-info">
                            <img src="assets/reviews/jane-doe.png" alt="Jane Doe">
                            <div class="reviewer-name">
                                <h5>Adi Fajar</h5>
                                <span>Google Reviews</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="review-card">
                        <p>"An excellent transfer. I only use Drivewise. They are easy to use, and the prices never disappoints."</p>
                        <div class="reviewer-info">
                            <img src="assets/reviews/peter-jones.png" alt="Peter Jones">
                            <div class="reviewer-name">
                                <h5>Veki A</h5>
                                <span>Google Reviews</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a href="#" class="btn btn-see-more-reviews">See more reviews</a>
        </div>
    </section>

    <footer class="footer-section">
        <div class="container-fluid container-fluid-custom">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">
                    <div class="footer-logo">
                        <img src="assets/Logo - Drivewise.png" alt="Drivewise Logo">
                    </div>
                    <p style="opacity: 0.8; font-size: 0.9em;">Drivewise: Sewa Mobil Jadi Lebih Mudah Bersama Drivewise. Mulai perjalanan nyamanmu.</p>
                </div>
                <div class="col-md-2 col-6">
                    <h5>Menu</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Home</a></li>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Services</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-2 col-6">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Terms of Service</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Careers</a></li>
                    </ul>
                </div>
                <div class="col-md-2 col-6">
                    <h5>Locations</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Jakarta</a></li>
                        <li><a href="#">Surabaya</a></li>
                        <li><a href="#">Bali</a></li>
                        <li><a href="#">Medan</a></li>
                    </ul>
                </div>
                <div class="col-md-2 col-6">
                    <h5>Follow Us</h5>
                    <div class="footer-social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="footer-bottom">
                        <p>&copy; 2025 Drivewise. All Rights Reserved. <br>The content, design, and functionality of this app are protected by copyright laws and international treaties.</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>