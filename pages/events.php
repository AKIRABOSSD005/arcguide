<?php
require '../config/nocache.php';
include '../functions/eventCarousel.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$isGuest = !isset($_SESSION['user']) || empty($_SESSION['user']);
$flashMessage = $_SESSION['flash_message'] ?? null;
unset($_SESSION['flash_message']); // Only show once
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upcoming Events in San Miguel, Bulacan | ArcGuide</title>
    <link rel="icon" type="image/svg+xml" href="../assets/icons/logo.svg">
    <link rel="stylesheet" href="../assets/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet" />

    <style>
        .events-section {
            background: linear-gradient(120deg, #114f89 60%, #46b07d 100%);
            color: #fff;
            padding: 3rem 0 2rem 0;
            text-align: center;
        }

        .carousel-item img {
            object-fit: cover;
            width: 100%;
            max-width: 1000px;
            height: 500px;
            background: #f8f5ee;
            display: block;
            margin: 0 auto;
            border-radius: 1rem;
            /* optional */
        }


        .carousel-caption {
            background: rgba(17, 79, 137, 0.78);
            border-radius: 1rem;
            padding: 1.5rem 1rem;
            left: 50%;
            transform: translateX(-50%);
            max-width: 600px;
        }

        @media (max-width: 576px) {
            .carousel-item img {
                height: 220px;
            }

            .carousel-caption {
                padding: 1rem 0.5rem;
                font-size: 0.95rem;
            }
        }

        .calendar-placeholder {
            background: #f8f9fa;
            border-radius: 1rem;
            min-height: 340px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #114f89;
            font-size: 1.2rem;
            margin-bottom: 2rem;
        }

        .featured-event {
            background: linear-gradient(90deg, #46b07d 60%, #114f89 100%);
            color: #fff;
            border-radius: 1rem;
            padding: 2rem 1.5rem;
            margin-bottom: 2rem;
        }

        .featured-event .btn {
            background: #fff;
            color: #114f89;
            border: none;
        }

        .featured-event .btn:hover {
            background: #e6f2ff;
        }

        .gallery-img {
            object-fit: cover;
            width: 100%;
            aspect-ratio: 1/1;
            border-radius: 0.75rem;
            box-shadow: 0 2px 8px rgba(17, 79, 137, 0.08);
        }

        .filter-section .form-select,
        .filter-section .form-label {
            min-width: 120px;
        }

        .submit-section {
            background: #f8f9fa;
            border-radius: 1rem;
            padding: 2rem 1.5rem;
            margin-bottom: 2rem;
        }

        /* Center FullCalendar toolbar buttons on all screens */
        .fc-toolbar-chunk {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
        }

        /* Hide FullCalendar's default month/year title */
        .fc-toolbar-title {
            display: none !important;
        }

        /* For mobile: stack or center even more tightly */
        @media (max-width: 768px) {
            .fc-toolbar-chunk {
                flex: 1 1 100%;
                justify-content: center !important;
            }

            .fc-toolbar {
                flex-wrap: wrap;
            }
        }
    </style>
</head>

<body>
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg bg-body-light px-3 px-md-5">
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
                        <li class="nav-item"><a class="nav-link" href="../index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="about.php">About San Miguel</a></li>
                        <li class="nav-item"><a class="nav-link" href="spots.php">Tourists Spots</a></li>
                        <li class="nav-item"><a class="nav-link" href="maps.php">Maps</a></li>
                        <li class="nav-item"><a class="nav-link" href="events.php">Events</a></li>
                        <?php if (isset($_SESSION['user'])): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
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


                    </ul>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="events-section">
            <div class="container">
                <h1 class="display-5 fw-bold mb-3">🎉 Upcoming Events in San Miguel, Bulacan</h1>
                <p class="lead mb-0">Discover, join, and celebrate the best happenings in our vibrant community!</p>
            </div>
        </section>

        <main class="main py-4" style="background: #f8f5ee;">
            <div class="container">
                <!-- Events Carousel -->
                <div id="eventsCarousel" class="carousel slide mb-5" data-bs-ride="carousel" data-bs-interval="5000">
                    <div class="carousel-inner" id="carouselInner">
                        <?php if (count($events) === 0): ?>
                            <div class="carousel-item active text-center p-5">No events found.</div>
                        <?php else: ?>
                            <?php foreach ($events as $index => $event): ?>
                                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                    <div class="d-flex flex-column align-items-center justify-content-center text-center p-4"
                                        style="min-height: 300px;">
                                        <img src="<?= htmlspecialchars($event['image']) ?>" class="mb-3 rounded"
                                            alt="<?= htmlspecialchars($event['title']) ?>">


                                        <h5><?= htmlspecialchars($event['title']) ?></h5>
                                        <p class="text-muted small"><?= htmlspecialchars($event['description']) ?></p>
                                        <p class="text-muted small">
                                            <strong><?= htmlspecialchars($event['location']) ?></strong><br>
                                            <?= date("F j, Y", strtotime($event['start_date'])) ?> –
                                            <?= date("F j, Y", strtotime($event['end_date'])) ?>
                                        </p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <button class="carousel-control-prev" type="button" data-bs-target="#eventsCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#eventsCarousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>



                <!-- Events Calendar Section -->
                <section class="mb-5">
                    <h2 class="fw-bold mb-3 text-center" style="color:#114f89;">🗓️ Events Calendar</h2>
                    <div class="mb-3 text-center">
                        <select id="monthDropdown" class="form-select w-auto d-inline-block">
                            <option value="" disabled selected>Select a Month</option>
                            <option value="0">January</option>
                            <option value="1">February</option>
                            <option value="2">March</option>
                            <option value="3">April</option>
                            <option value="4">May</option>
                            <option value="5">June</option>
                            <option value="6">July</option>
                            <option value="7">August</option>
                            <option value="8">September</option>
                            <option value="9">October</option>
                            <option value="10">November</option>
                            <option value="11">December</option>
                        </select>
                    </div>

                    <h2 class="fw-bold mb-3 text-center" id="month-name" style="color:#114f89;"></h2>

                    <div id="calendar"></div>
                </section>

                <!-- Featured Event Section -->
                <section class="featured-event mb-5">
                    <div class="row align-items-center">
                        <div class="col-12 col-md-8">
                            <h2 class="fw-bold mb-2">🌟 Featured Event: San Miguel Town Fiesta</h2>
                            <p class="mb-1"><i class="bi bi-calendar-event"></i> <strong>May 8, 2025</strong></p>
                            <p class="mb-2"><i class="bi bi-geo-alt"></i> San Miguel Church & Town Plaza</p>
                            <p class="mb-3">A week-long celebration with processions, street dancing, food fairs, and
                                cultural shows in honor of St. Michael the Archangel.</p>
                            <a href="maps.php" class="btn btn-light fw-semibold px-4">View on Map</a>
                        </div>
                        <div class="col-12 col-md-4 text-center mt-3 mt-md-0">
                            <img src="../assets/icons/R.jpg" alt="San Miguel Town Fiesta"
                                class="img-fluid rounded-3 shadow" style="max-height:180px;">
                        </div>
                    </div>
                </section>

                <!-- Submit Your Event Section -->
                <section class="submit-section mb-5">
                    <h2 class="fw-bold mb-3" style="color:#114f89;">📤 Submit Your Event</h2>
                    <form method="POST" action="../functions/events_submit.php" enctype="multipart/form-data">
                        <input type="hidden" name="visitorDateTime"
                            id="visitorDateTime"><!-- 👈 hidden local datetime -->

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="title" class="form-label text-dark">Event Name</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                            <div class="col-md-3">
                                <label for="start_date" class="form-label text-dark">Start Date</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" required>
                            </div>
                            <div class="col-md-3">
                                <label for="end_date" class="form-label text-dark">End Date</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" required>
                            </div>
                            <div class="col-md-6">
                                <label for="location" class="form-label text-dark">Location</label>
                                <input type="text" class="form-control" id="location" name="location" required>
                            </div>
                            <div class="col-md-6">
                                <label for="image" class="form-label text-dark">Image</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            </div>
                            <div class="col-md-6">
                                <label for="category_id" class="form-label text-dark">Category</label>
                                <select class="form-select" id="category_id" name="category_id" required>
                                    <option value="" disabled selected>Select a Category</option>
                                    <option value="1">Festival</option>
                                    <option value="2">Cultural Show</option>
                                    <option value="3">Parade</option>
                                    <option value="4">Community Fair</option>
                                    <option value="5">Historical Exhibit</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="description" class="form-label text-dark">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3"
                                    required></textarea>
                            </div>
                            <div class="col-12 text-end">
                                <button type="submit" name="submitEvent" id="submitEventID"
                                    class="btn btn-success px-4">Submit Event</button>
                            </div>
                        </div>
                    </form>
                </section>

                <!-- Past Events Section -->
                <section class="mb-5">
                    <div class="card shadow-sm border-0">
                        <div class="card-header" style=" background: linear-gradient(90deg, #46b07d 60%, #114f89 100%)">
                            <h5 class="mb-0 fw-bold text-light">🕰️ Past Events</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3" id="past-events-container">
                                <!-- Past event cards will be injected here -->
                            </div>
                        </div>
                    </div>
                </section>


            </div>
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


        <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1080;">
            <?php if ($flashMessage): ?>
                <div id="flashToast" class="toast border-0 shadow-sm rounded-4 bg-success text-white" role="alert"
                    aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
                    <div class="d-flex align-items-center p-3">
                        <div class="toast-body fs-6">
                            <?= htmlspecialchars($flashMessage) ?>
                        </div>
                        <button type="button" class="btn-close btn-close-white ms-auto me-1" data-bs-dismiss="toast"
                            aria-label="Close"></button>
                    </div>
                </div>
            <?php endif; ?>
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
                        <a href="../functions/logout.php" class="btn btn-danger">Yes, Logout</a>
                    </div>
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
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <!-- Toast -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const isGuest = <?= json_encode($isGuest) ?>;

            if (isGuest) {
                const toast = new bootstrap.Toast(document.getElementById('guestToast'));
                toast.show();
            }
        });
    </script>


    <!-- Script 2: Initialize FullCalendar and Enable Month Switching -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const calendarEl = document.getElementById('calendar');
            const monthNameEl = document.getElementById('month-name');
            const monthDropdown = document.getElementById('monthDropdown');

            // ...existing code...
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: 'auto',
                events: '../functions/calendar.php',
                eventColor: '#46b07d',
                eventTextColor: '#fff',
                dayMaxEventRows: 5, // Show up to 5 events per day, then "+ more"
                eventDisplay: 'block', // Ensures events are stacked
                datesSet: function (info) {
                    updateMonthTitle(calendar.getDate());
                },
                eventDidMount: function (info) {
                    // Make event text readable and show title on hover
                    info.el.style.fontSize = '1em';
                    info.el.style.padding = '3px 6px';
                    info.el.style.whiteSpace = 'nowrap';
                    info.el.style.overflow = 'hidden';
                    info.el.style.textOverflow = 'ellipsis';
                    info.el.title = info.event.title; // Show title as tooltip on hover
                }
            });
            // ...existing code...

            calendar.render();

            // Helper: update the month title heading
            function updateMonthTitle(date) {
                const month = date.toLocaleString('default', { month: 'long' });
                const year = date.getFullYear();
                monthNameEl.textContent = `${month} ${year}`;
            }

            updateMonthTitle(calendar.getDate()); // Initial display

            // Update calendar when dropdown month is changed
            monthDropdown.addEventListener('change', function () {
                const selectedMonth = parseInt(this.value);
                const currentYear = new Date().getFullYear();
                const targetDate = new Date(currentYear, selectedMonth, 1);

                calendar.gotoDate(targetDate);
                updateMonthTitle(targetDate);
            });
        });
    </script>

    <!-- Script 3: Load Past Events and Display Them as Cards -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            fetch('../functions/pastEvents.php')
                .then(response => response.json())
                .then(events => {
                    const container = document.getElementById('past-events-container');

                    if (events.length === 0) {
                        container.innerHTML = `<div class="col-12"><p class="text-muted text-center mb-0">No past events found.</p></div>`;
                        return;
                    }

                    events.forEach(event => {
                        const card = document.createElement('div');
                        card.className = 'col-md-4';
                        card.innerHTML = `
                        <div class="card h-100">
                            <img src="../${event.image}" class="card-img-top" alt="${event.title}" style="object-fit:cover; height:200px;">
                            <div class="card-body">
                                <h5 class="card-title">${event.title}</h5>
                                <p class="card-text small text-muted">${event.description}</p>
                                <p class="card-text text-muted mb-1"><strong>${event.location}</strong></p>
                                <p class="card-text"><small>${new Date(event.start_date).toLocaleDateString()} – ${new Date(event.end_date).toLocaleDateString()}</small></p>
                            </div>
                        </div>
                    `;
                        container.appendChild(card);
                    });
                })
                .catch(err => {
                    console.error("Failed to load past events:", err);
                });
        });
    </script>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const visitorInput = document.getElementById('visitorDateTime');

            if (visitorInput) {
                const now = new Date();

                // Format as YYYY-MM-DD HH:MM:SS
                const visitorDateTime = now.getFullYear() + '-' +
                    String(now.getMonth() + 1).padStart(2, '0') + '-' +
                    String(now.getDate()).padStart(2, '0') + ' ' +
                    String(now.getHours()).padStart(2, '0') + ':' +
                    String(now.getMinutes()).padStart(2, '0') + ':' +
                    String(now.getSeconds()).padStart(2, '0');

                visitorInput.value = visitorDateTime;
            }
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const flashToastEl = document.getElementById('flashToast');
            if (flashToastEl) {
                const toast = new bootstrap.Toast(flashToastEl);
                toast.show();
            }
        });
    </script>




</body>

</html>