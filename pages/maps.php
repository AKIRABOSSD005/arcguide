<?php
require '../config/nocache.php';
include '../functions/pinLocations.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$isGuest = !isset($_SESSION['user']) || empty($_SESSION['user']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interactive Map| ArcGuide</title>
    <link rel="icon" type="image/svg+xml" href="../assets/icons/logo.svg">
    <link rel="stylesheet" href="../assets/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body>
    <div class="wrapper">
        <nav class="navbar navbar-expand-lg bg-body-light px-5">
            <div class="container-fluid justify-content-center">
                <a class="navbar-brand mx-auto" href="../index.php" onclick="reloadPage()">
                    <img src="../assets/icons/logo.svg" alt="Logo" class="logo d-inline-block align-text-top" />
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="../index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="about.php">About San Miguel</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="spots.php">Tourists Spots</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="maps.php">Maps</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="events.php">Events</a>
                        </li>
                        <li class="nav-item">
                            <?php if (isset($_SESSION['user'])): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="#" onclick="alert('You are already logged in.'); return false;">
                                    <img src="<?= htmlspecialchars($_SESSION['user']['picture']) ?>" alt="Profile Image" 
                                    class="rounded-circle" width="32" height="32" style="object-fit: cover;">

                                </a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link" href="loginPage.php">
                                    <span class="profile-icon"></span>
                                </a>
                            </li>
                        <?php endif; ?>


                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="main">
            <div class="map-hero-section d-flex align-items-center py-5" id="map-hero">
                <div class="map-hero-content text-white">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-12 col-lg-8 text-start">
                                <h1 class="fw-bold display-5 mb-3">🌄 Discover San Miguel, Bulacan</h1>
                                <p class="lead mb-4 text-light">
                                    Explore historic landmarks, scenic trails, rivers, caves, and more — all on our
                                    interactive map.
                                    Click a marker to learn more!
                                </p>

                                <!-- Search Bar -->
                                <div class="search-wrapper custom-search-group">
                                    <div class="d-none d-sm-flex input-group input-group-lg">
                                        <input type="text" id="spotSearch" class="form-control"
                                            placeholder="🔍 Search for a tourist spot...">
                                        <button class="btn btn-light" onclick="searchSpot()">Search</button>
                                    </div>
                                    <div class="d-flex d-sm-none flex-column gap-2">
                                        <input type="text" id="spotSearchMobile" class="form-control form-control-lg"
                                            placeholder="🔍 Search for a tourist spot...">
                                        <button class="btn btn-light btn-lg w-100"
                                            onclick="searchSpot()">Search</button>
                                    </div>
                                </div>

                                <!-- Filter Buttons -->
                                <div class="d-flex flex-wrap gap-2 mb-4">
                                    <button class="btn btn-outline-light btn-sm px-3 filter-btn active"
                                        data-filter="all" onclick="filterSpots('all')">All</button>
                                    <button class="btn btn-outline-light btn-sm px-3 filter-btn" data-filter="hiking"
                                        onclick="filterSpots('Hiking')">🥾 Hiking</button>
                                    <button class="btn btn-outline-light btn-sm px-3 filter-btn" data-filter="swimming"
                                        onclick="filterSpots('Swimming')">🏊 Swimming</button>
                                    <button class="btn btn-outline-light btn-sm px-3 filter-btn"
                                        data-filter="historical" onclick="filterSpots('Historical')">🏛️
                                        Historical</button>
                                    <button class="btn btn-outline-light btn-sm px-3 filter-btn"
                                        data-filter="sightseeing" onclick="filterSpots('Sightseeing')">🌅
                                        Sightseeing</button>
                                </div>


                                <!-- Mini Map Legend -->
                                <div class="d-inline-flex align-items-center bg-light rounded-pill shadow-sm px-3 py-2 mb-4"
                                    style="font-size: 0.9rem;">
                                    <i class="bi bi-geo-alt-fill text-primary fs-5 me-2"></i>
                                    <span class="text-dark">Click a <strong>marker</strong> to view details</span>
                                </div>

                                <!-- Explore Button -->
                                <a href="#map" class="btn btn-success btn-lg rounded-pill px-5 fw-semibold shadow-sm"
                                    style="font-size: 1rem;">
                                    🌐 Explore the Map
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <section class="bg-white text-dark py-5 border-top">
                <div class="container text-center">
                    <h2 class="fw-bold mb-3">🗺️ What Can You Explore on the Map?</h2>
                    <p class="lead mb-4">The ArcGuide interactive map highlights over <strong>30+ tourist
                            destinations</strong> across San Miguel, Bulacan.</p>

                    <div class="row justify-content-center g-4">
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="p-3 bg-light rounded shadow-sm h-100">
                                <i class="bi bi-signpost-2-fill text-primary fs-1 mb-2"></i>
                                <h6 class="fw-bold">Historical Spots</h6>
                                <p class="small text-muted">Visit heritage homes, shrines, and historic monuments.</p>
                            </div>
                        </div>
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="p-3 bg-light rounded shadow-sm h-100">
                                <i class="bi bi-tree-fill text-success fs-1 mb-2"></i>
                                <h6 class="fw-bold">Nature Trails</h6>
                                <p class="small text-muted">Explore caves, rivers, mountains, and protected parks.</p>
                            </div>
                        </div>
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="p-3 bg-light rounded shadow-sm h-100">
                                <i class="bi bi-camera-fill text-warning fs-1 mb-2"></i>
                                <h6 class="fw-bold">Scenic Views</h6>
                                <p class="small text-muted">Perfect selfie spots and relaxing sightseeing areas.</p>
                            </div>
                        </div>
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="p-3 bg-light rounded shadow-sm h-100">
                                <i class="bi bi-geo-alt-fill text-danger fs-1 mb-2"></i>
                                <h6 class="fw-bold">All-in-One Map</h6>
                                <p class="small text-muted">Use filters or search to find your next adventure spot.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>






            <div id="map" style="height: 600px; width: 100%;"></div>

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





    <script src="../assets/bootstrap-5.3.3-dist/js/bootstrap.bundle.js"></script>
    <script src="../assets/js/script.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const isGuest = <?= json_encode($isGuest) ?>;

            if (isGuest) {
                const toast = new bootstrap.Toast(document.getElementById('guestToast'));
                toast.show();
            }

        });
    </script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDQQWsi8gFQ4IK9c2GgWSnnbey0lq3K-_U&callback=initMap&loading=async"
        async></script>


    <script>
        let map; // make map global
        let mapMarkers = []; // global array for markers and spots

        function initMap() {
            const sanMiguel = { lat: 15.1503, lng: 120.9610 };
            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 12,
                center: sanMiguel,
            });

            const spots = <?php echo json_encode($spots, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>;


            spots.forEach((spot, index) => {
                const marker = new google.maps.Marker({
                    position: spot.position,
                    map: map,
                    title: spot.title,
                });

                const infoWindow = new google.maps.InfoWindow({
                    content: `
                    <div style="max-width:200px">
                        <h6>${spot.title}</h6>
                        <img src="${spot.image}" style="width:100%;border-radius:8px" />
                        <p class="text-muted small">${spot.description}</p>
                    </div>
                `,
                });

                marker.addListener("click", () => {
                    infoWindow.open(map, marker);
                });

                mapMarkers.push({ marker, spot }); // store both marker and spot
            });
        }

        window.searchSpot = function () {
            // Check both desktop and mobile input fields
            const inputDesktop = document.getElementById('spotSearch');
            const inputMobile = document.getElementById('spotSearchMobile');
            const inputValue = (inputDesktop && inputDesktop.offsetParent !== null)
                ? inputDesktop.value.trim()
                : (inputMobile ? inputMobile.value.trim() : '');

            // Show warning if empty
            if (!inputValue) {
                showSearchWarning('Please enter a tourist spot to search.');
                return;
            }

            const input = inputValue.toLowerCase();

            // Fuzzy/partial matching: split input into words and match any word in any spot field
            const matchEntry = mapMarkers.find(entry => {
                const text = [
                    entry.spot.title,
                    entry.spot.description,
                    entry.spot.location
                ].filter(Boolean).join(' ').toLowerCase();

                // Split input into words and check if any word is present in the text
                return input.split(/\s+/).some(word => text.includes(word));
            });

            if (matchEntry) {
                document.getElementById('map').scrollIntoView({ behavior: 'smooth' });

                map.setCenter(matchEntry.spot.position);
                map.setZoom(15);

                const infoWindow = new google.maps.InfoWindow({
                    content: `
            <div style="max-width:200px">
                <h6>${matchEntry.spot.title}</h6>
                <img src="${matchEntry.spot.image}" style="width:100%;border-radius:8px" />
                <p class="text-muted small">${matchEntry.spot.description}</p>
            </div>
        `,
                });
                infoWindow.open(map, matchEntry.marker);
            } else {
                showSearchWarning('Spot not found.');
            }
        }

        // Helper to show warning above the search bar
        function showSearchWarning(message) {
            let alertDiv = document.getElementById('searchWarning');
            if (!alertDiv) {
                alertDiv = document.createElement('div');
                alertDiv.id = 'searchWarning';
                alertDiv.className = 'alert alert-warning py-2 px-3 mb-3';
                alertDiv.style.position = 'relative';
                alertDiv.style.zIndex = 10;
                const searchWrapper = document.querySelector('.search-wrapper');
                searchWrapper.parentNode.insertBefore(alertDiv, searchWrapper);
            }
            alertDiv.textContent = message;
            alertDiv.style.display = 'block';
            setTimeout(() => {
                alertDiv.style.display = 'none';
            }, 2500);
        }

        window.filterSpots = function (keyword) {
            keyword = keyword.toLowerCase();

            // Update button active state
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.classList.remove('active');
                if (btn.dataset.filter === keyword) {
                    btn.classList.add('active');
                }
            });

            // Filter markers
            mapMarkers.forEach(({ marker, spot }) => {
                const matches = keyword === 'all' || spot.description.toLowerCase().includes(keyword);
                marker.setVisible(matches);
            });

            // Save currently active filter globally for search
            window.currentFilter = keyword;

        }
    </script>



</body>

</html>