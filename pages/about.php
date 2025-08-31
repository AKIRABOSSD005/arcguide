<?php
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
    <title>About San Miguel | ArcGuide</title>
    <link rel="icon" type="image/svg+xml" href="../assets/icons/logo.svg">
    <link rel="stylesheet" href="../assets/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
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

        <main class="main">
            <section class="about-section py-5" style="background: #f8f5ee;">
                <div class="container">
                    <div class="row mb-4">
                        <div class="col-12 col-lg-10 mx-auto text-center">
                            <h1 class="fw-bold mb-3 about-title">About San Miguel</h1>
                            <p class="lead text-muted mb-0">
                                Discover the rich history, culture, and community of San Miguel, Bulacan.
                            </p>
                        </div>
                    </div>
                    <div class="row g-4">
                        <!-- History Card -->
                        <div class="col-12 col-lg-7">
                            <div class="about-card card h-100 shadow-sm border-0 p-4">
                                <h3 class="fw-bold mb-3 about-title">History</h3>
                                <p class="mb-2 text-muted" style="text-align:justify;">
                                    San Miguel is one of the most progressive towns in Bulacan. Miguel Pineda in 1763,
                                    the first "Captain Municipal" of the place founded it.
                                    It was said that Miguel Pineda, a native of Angat, went hunting one day and he
                                    happened to reach barrio San Bartolome, located at the foot of the Sierra Madre
                                    Mountains. Finding the place suitable for this chosen by the settlers to be their
                                    leader.
                                </p>
                                <p class="mb-2 text-muted" style="text-align:justify;">
                                    The barrio improved through his leadership and decides to expand their territory. He
                                    then later discovered a progressive community named Sto. Rosario whose leader was
                                    Mariano Puno. The two agreed to form a town between Bartolome (now Tartaro) and Sto.
                                    Rosario (now Mandile). They chose Miguel Mayumo to be the name of the town, which
                                    should be included in the province of Pampanga. Miguel was in honor of Miguel Pineda
                                    and Mayumo, a Pampango word for "sweet", stands for the goodwill and generosity of
                                    Puno.
                                </p>
                                <p class="mb-2 text-muted" style="text-align:justify;">
                                    Years passed by, the people, during a meeting presided over by Pineda, endorsed to
                                    give the town a better name. In the course of their meeting, an excited man came in
                                    and then related an unusual tale.
                                </p>
                                <p class="mb-2 text-muted" style="text-align:justify;">
                                    He claimed that one night on his way home after gathering bundles of firewood which
                                    he placed on a raft, a big rock blocked his way along the river. He tried to find
                                    another way but could not make it. Suddenly, a strong wind lashed at him followed by
                                    heavy rains. He hurriedly left the raft and sought shelter inside a cave. He
                                    continued that he fell asleep as he waited for the rain to stop.
                                </p>
                                <p class="mb-2 text-muted" style="text-align:justify;">
                                    At midnight, a blinding light woke him up. Stunned, he stood up as he sensed
                                    something was happening when another dazzling light brightened the cave. He went to
                                    another part of the cave and later on he discovered a hallowed winged figure. He was
                                    sure, a miracle happened. He went back at the town and narrated the story. Some
                                    people led by Captain Miguel went there to see for themselves the miracle. They saw
                                    the winged figure, which looked like Saint Michael, the Prince of the Angels. They
                                    believed that the discovery of the Angel was God's blessing and a sign of good
                                    graces to the inhabitants. In this connection, the people of Miguel Mayumo deemed it
                                    proper and timely to add "Sam" to the name of the town in reference and homage to
                                    the discovery of the image of Arcangel. Hence, San Miguel de Mayumo became the
                                    complete name of the town. However, the official name of the town at present is
                                    simply San Miguel.
                                </p>
                            </div>
                        </div>
                        <!-- Fast Facts Card -->
                        <div class="col-12 col-lg-5">
                            <div class="about-card card h-100 shadow-sm border-0 p-4">
                                <h3 class="fw-bold mb-3 about-title">Fast Facts</h3>
                                <ul class="about-facts-list list-unstyled mb-3">
                                    <li><strong>Land Area:</strong> 26,524 has</li>
                                    <li><strong>No. of Barangays:</strong> 49</li>
                                    <li><strong>Population (2015):</strong> 153,882</li>
                                </ul>
                                <h5 class="fw-bold mt-4 mb-2 about-title">Major Industries</h5>
                                <ul class="list-unstyled mb-3">
                                    <li>Agricultural, Food Art, Food Products</li>
                                </ul>
                                <h5 class="fw-bold mt-4 mb-2 about-title">Major Products</h5>
                                <ul class="list-unstyled mb-3">
                                    <li>Vegetables, Sweets and Delicacies, Chicharon</li>
                                </ul>
                                <h5 class="fw-bold mt-4 mb-2 about-title">Municipal Officials</h5>
                                <ul class="list-unstyled mb-3">
                                    <li><strong>Mayor:</strong> Roderick DG. Tiongson</li>
                                    <li><strong>Vice Mayor:</strong> John A. Alvarez</li>
                                </ul>
                                <h5 class="fw-bold mt-4 mb-2 about-title">Mailing Address</h5>
                                <address class="mb-0">
                                    EnP. Pedro R. Sambas<br>
                                    Municipal Planning and Development Office<br>
                                    Municipality of San Miguel, Bulacan<br>
                                    San Miguel, Bulacan 3011 Philippines
                                </address>
                            </div>
                        </div>
                    </div>
                    <!-- Barangays Card -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="about-card card shadow-sm border-0 p-4">
                                <h3 class="fw-bold mb-3 about-title">
                                    <span class="about-barangays-toggle" onclick="toggleBarangays()">Barangays of San
                                        Miguel <span id="barangays-arrow">&#9660;</span></span>
                                </h3>
                                <div id="about-barangays-list" class="about-barangays-list">
                                    <div class="row">
                                        <div class="col-12 col-md-6 col-lg-3">
                                            <ul class="list-unstyled small">
                                                <li>1. Bagong Pag-asa</li>
                                                <li>2. Bagong Silang</li>
                                                <li>3. Balaong</li>
                                                <li>4. Balite</li>
                                                <li>5. Bantog</li>
                                                <li>6. Bardias</li>
                                                <li>7. Baritan</li>
                                                <li>8. Batasan Bata</li>
                                                <li>9. Batasan Matanda</li>
                                                <li>10. Biak-na-Bato</li>
                                                <li>11. Biclat</li>
                                                <li>12. Buga</li>
                                            </ul>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-3">
                                            <ul class="list-unstyled small">
                                                <li>13. Buliran</li>
                                                <li>14. Bulualto</li>
                                                <li>15. Calumpang</li>
                                                <li>16. Cambio</li>
                                                <li>17. Camias</li>
                                                <li>18. Ilog-Bulo</li>
                                                <li>19. King Kabayo</li>
                                                <li>20. Labne</li>
                                                <li>21. Lambakin</li>
                                                <li>22. Magmarale</li>
                                                <li>23. Malibay</li>
                                                <li>24. Maligaya</li>
                                            </ul>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-3">
                                            <ul class="list-unstyled small">
                                                <li>25. Mandile</li>
                                                <li>26. Masalipit</li>
                                                <li>27. Pacalag</li>
                                                <li>28. Paliwasan</li>
                                                <li>29. Partida</li>
                                                <li>30. Pinambaran</li>
                                                <li>31. Poblacion</li>
                                                <li>32. Pulong Bayabas</li>
                                                <li>33. Pulong Duhat</li>
                                                <li>34. Sacdalan</li>
                                                <li>35. Salacot</li>
                                                <li>36. Salangan</li>
                                            </ul>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-3">
                                            <ul class="list-unstyled small">
                                                <li>37. San Agustin</li>
                                                <li>38. San Jose</li>
                                                <li>39. San Juan</li>
                                                <li>40. San Vicente</li>
                                                <li>41. Santa Ines</li>
                                                <li>42. Santa Lucia</li>
                                                <li>43. Santa Rita Bata</li>
                                                <li>44. Santa Rita Matanda</li>
                                                <li>45. Sapang</li>
                                                <li>46. Sibul</li>
                                                <li>47. Tartaro</li>
                                                <li>48. Tibagan</li>
                                                <li>49. Tigpalas</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

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
</body>

</html>