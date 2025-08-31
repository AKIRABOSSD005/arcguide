<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isGuest = !isset($_SESSION['user']) || empty($_SESSION['user']);

require_once 'functions/trackVisitor.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="dark">
    <title>ArcGuide: Tourism Hub for San Miguel Bulacan</title>
    <link rel="icon" type="image/svg+xml" href="assets/icons/logo.svg">
    <link rel="stylesheet" href="assets/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <div class="wrapper">
        <nav class="navbar navbar-expand-lg bg-body-light px-5">
            <div class="container-fluid justify-content-center">
                <a class="navbar-brand mx-auto" href="index.php" onclick="reloadPage()">
                    <img src="assets/icons/logo.svg" alt="Logo" class="logo d-inline-block align-text-top" />
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <!-- Example nav items -->
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Home</a>

                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="pages/about.php">About San Miguel</a>

                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="pages/spots.php">Tourists Spots</a>

                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="pages/maps.php">Maps</a>

                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="pages/events.php">Events</a>

                        </li>
                        <?php if (isset($_SESSION['user'])): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                                    <img src="<?= htmlspecialchars($_SESSION['user']['picture']) ?>" alt="Profile Image"
                                        class="rounded-circle" width="32" height="32" style="object-fit: cover;">
                                </a>
                            </li>

                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link" href="pages/loginPage.php">
                                    <span class="profile-icon"></span>
                                </a>
                            </li>
                        <?php endif; ?>


                    </ul>

                </div>
            </div>
        </nav>


        <div class="main">
            <div class="hero-section d-flex align-items-center" id="home">
                <div class="hero-content w-100">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 col-sm-10 col-md-8 col-lg-7 text-start">
                                <h1 class="display-3 fw-bold mb-3" style="color: #fff;">
                                    Tourism Hub for<br>San Miguel, Bulacan
                                </h1>
                                <p class="lead mb-4" style="color: #fff;">
                                    Welcome to ArchGuide – Your Gateway to Discovering San Miguel, Bulacan
                                </p>
                                <a class="btn btn-lg btn-explore" href="pages/spots.php">Explore</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Place after the hero-section in index.blade.php -->
            <section class="info-section py-5" style="background: #f8f5ee;">
                <div class="container">
                    <div class="row g-4">
                        <div class="col-12 col-md-6 col-lg-3 d-flex">
                            <a href="pages/about.php" class="text-decoration-none text-reset w-100 h-100">
                                <div
                                    class="arcguide-card card h-100 shadow-sm border-0 p-4 d-flex flex-column align-items-center">
                                    <div class="arcguide-card-img-wrapper mb-3">
                                        <img src="assets/picutures/faq.svg" alt="About">
                                    </div>
                                    <div class="card-body p-0 text-center d-flex flex-column flex-grow-1">
                                        <h5 class="card-title fw-bold mb-2" style="color:#114f89;">About San Miguel</h5>
                                        <p class="card-text mb-0">Learn about the history and culture of San Miguel</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3 d-flex">
                            <a href="pages/spots.php" class="text-decoration-none text-reset w-100 h-100">
                                <div
                                    class="arcguide-card card h-100 shadow-sm border-0 p-4 d-flex flex-column align-items-center">
                                    <div class="arcguide-card-img-wrapper mb-3">
                                        <img src="assets/picutures/tourSpot.svg" alt="About">
                                    </div>
                                    <div class="card-body p-0 text-center d-flex flex-column flex-grow-1">
                                        <h5 class="card-title fw-bold mb-2" style="color:#114f89;">Tourists Spots</h5>
                                        <p class="card-text mb-0">Discover the top tourist spots and attractions in San
                                            Miguel</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3 d-flex">
                            <a href="pages/maps.php" class="text-decoration-none text-reset w-100 h-100">
                                <div
                                    class="arcguide-card card h-100 shadow-sm border-0 p-4 d-flex flex-column align-items-center">
                                    <div class="arcguide-card-img-wrapper mb-3">
                                        <img src="assets/picutures/interactiveMap.svg" alt="About">
                                    </div>
                                    <div class="card-body p-0 text-center d-flex flex-column flex-grow-1">
                                        <h5 class="card-title fw-bold mb-2" style="color:#114f89;">Interactive Map</h5>
                                        <p class="card-text mb-0">Explore San Miguel with our interactive map feature
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3 d-flex">
                            <a href="pages/events.php" class="text-decoration-none text-reset w-100 h-100">
                                <div
                                    class="arcguide-card card h-100 shadow-sm border-0 p-4 d-flex flex-column align-items-center">
                                    <div class="arcguide-card-img-wrapper mb-3">
                                        <img src="assets/picutures/upEvents.svg" alt="About">
                                    </div>
                                    <div class="card-body p-0 text-center d-flex flex-column flex-grow-1">
                                        <h5 class="card-title fw-bold mb-2" style="color:#114f89;">Upcoming Events</h5>
                                        <p class="card-text mb-0">Stay updated with the latest events happening in San
                                            Miguel</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
            </section>



            <button class="about-backtotop" onclick="window.scrollTo({top:0,behavior:'smooth'})" title="Back to Top"
                style="display:none;">
                &uarr;
            </button>

            <div class="footer">
                <div class="container text-center py-4">
                    <p class="mb-0" style="color: #123c63;">&copy; 2025 ArcGuide. All rights reserved.</p>
                    <p class="mb-0" style="color: #123c63;">Made with ❤️ by EGDD</p>
                </div>
            </div>
        </div>

        <!-- Logout Confirmation Modal -->
        <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-dark" id="logoutModalLabel">Logout Confirmation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-dark">
                        Are you sure you want to log out?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                        <a href="functions/logout.php" class="btn btn-danger">Yes, Logout</a>
                    </div>
                </div>
            </div>
        </div>




    </div>
    <!-- Toast Container -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1080;">
        <div id="guestToast" class="toast border-0 shadow-sm rounded-4 bg-white text-dark" role="alert"
            aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
            <div class="d-flex align-items-center p-3">
                <!-- Icon (Optional SVG for minimalism) -->
                <div class="me-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#114f89"
                        class="bi bi-person-circle" viewBox="0 0 16 16">
                        <path d="M11 10a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                        <path fill-rule="evenodd"
                            d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 1 0 0 14A7 7 0 0 0 8 1z" />
                    </svg>
                </div>
                <!-- Message -->
                <div class="toast-body fs-6 text-dark pe-2">
                    You are browsing as a guest.
                </div>
                <!-- Close Button -->
                <button type="button" class="btn-close ms-auto me-1" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>



    <script src="assets/bootstrap-5.3.3-dist/js/bootstrap.bundle.js"></script>
    <script src="assets/js/script.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Get visitor's local datetime in format YYYY-MM-DD HH:MM:SS
            const visitorTime = new Date();
            const visitorDateTime = visitorTime.getFullYear() + '-' +
                String(visitorTime.getMonth() + 1).padStart(2, '0') + '-' +
                String(visitorTime.getDate()).padStart(2, '0') + ' ' +
                String(visitorTime.getHours()).padStart(2, '0') + ':' +
                String(visitorTime.getMinutes()).padStart(2, '0') + ':' +
                String(visitorTime.getSeconds()).padStart(2, '0');

            // Send to server via POST
            fetch('functions/trackVisitor.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'visitorDateTime=' + encodeURIComponent(visitorDateTime)
            })
                .catch(err => console.error('Visitor tracking error:', err));
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const isGuest = <?= json_encode($isGuest) ?>;

            if (isGuest) {
                const toast = new bootstrap.Toast(document.getElementById('guestToast'));
                toast.show();
            }

        });
    </script>

</body>

</html>