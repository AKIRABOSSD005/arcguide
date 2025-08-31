<?php
// Start the session if not already started
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
    <meta name="color-scheme" content="dark">
    <title>ArcGuide: Tourism Hub for San Miguel Bulacan</title>
    <link rel="icon" type="image/svg+xml" href="../assets/icons/logo.svg">
    <link rel="stylesheet" href="../assets/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.lineicons.com/4.0/lineicons.css">

    <div class="wrapper">
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-logo">
                <img src="../assets/icons/logo.svg" alt="ArcGuide Logo" class="logo-full" onclick="location.reload()">
                <img src="../assets/icons/logo.svg" alt="ArcGuide Logo Icon" class="logo-mini"
                    onclick="location.reload()">

            </div>
            <div class="sidebar-toggler-box">
                <button id="sidebarToggler" class="toggle-btn" type="button"
                    style="background:transparent;border:none;">
                    <i class="bi bi-list"></i>
                </button>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="dashboard.php" class="sidebar-link active" title="Dashboard">
                        <i class="lni lni-bar-chart"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="spots" class="sidebar-link" title="Manage Tourist Spots">
                        <i class="lni lni-map"></i>
                        <span>Manage Tourist Spots</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link" title="Manage Events">
                        <i class="lni lni-calendar"></i>
                        <span>Manage Events</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link" title="Maps Editor">
                        <i class="lni lni-pencil"></i>
                        <span>Maps Editor</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link" title="User Management">
                        <i class="lni lni-users"></i>
                        <span>User Management</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link" title="Settings">
                        <i class="lni lni-cog"></i>
                        <span>Settings</span>
                    </a>
                </li>
            </ul>
        </aside>


        <main class="content flex-grow-1" style="margin-left:260px; transition:margin-left 0.3s;">
            <div class="container-fluid py-4">
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap mx-5 dashboard-header">
                    <h5 class="fw-semibold mb-0">
                        Welcome Back Admin <span class="waving-hand">👋</span>
                    </h5>
                    <div class="d-flex align-items-center gap-2">
                        <span class="fw-semibold mt-2">
                            <?php echo htmlspecialchars($_SESSION['user']['name'] ?? 'Guest'); ?>
                        </span>
                        
                        <img src="<?= htmlspecialchars($_SESSION['user']['picture']) ?>" alt="Profile"
                            class="rounded-circle" width="36" height="36" style="object-fit: cover;">
                    </div>
                </div>





                <div class="row g-3 mb-4">
                    <?php
                    // Example: Fetch actual counts from your data sources
                    // You may need to adjust these based on your actual data structure
                    
                    include_once '../functions/eventCarousel.php';
                    include_once '../functions/pinLocations.php';
                    require_once '../functions/spotsData.php';
                    require_once '../functions/usersCount.php';


                    $eventsCount = isset($events) ? count($events) : 0;
                    $mapPinsCount = isset($spots) ? count($spots) : 0;
                    $touristSpotsCount = isset($spots) ? count($spots) : 0;

                    $dashboardCards = [

                        [
                            'icon' => '../assets/icons/events.svg',
                            'count' => $eventsCount,
                            'label' => 'Events'
                        ],
                        [
                            'icon' => '../assets/icons/map.svg',
                            'count' => $mapPinsCount,
                            'label' => 'Map Pins'
                        ],
                        [
                            'icon' => '../assets/icons/person1.svg',
                            'count' => $usersCount,
                            'label' => 'Users'
                        ],
                        [
                            'icon' => '../assets/picutures/tourSpot.svg',
                            'count' => $touristSpotsCount,
                            'label' => 'Tourist Spots'
                        ]
                    ];
                    foreach ($dashboardCards as $card):
                        ?>
                        <div class="col-md-3 col-6">
                            <div class="card shadow-sm border-0 text-center py-3">
                                <img src="<?php echo $card['icon']; ?>"
                                    alt="<?php echo htmlspecialchars($card['label']); ?>"
                                    style="width:60px;height:60px;object-fit:contain;margin-bottom:1px;margin-left:auto;margin-right:auto;">
                                <div class="fs-3 fw-bold"><?php echo $card['count']; ?></div>

                                <div class="text-muted"><?php echo htmlspecialchars($card['label']); ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body">
                                <h6 class="card-title mb-2">Visitors per Year</h6>
                                <canvas id="visitorsChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body">
                                <h6 class="card-title mb-2">Tourist Spots by Category</h6>
                                <canvas id="spotsChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <h6 class="card-title mb-2">Recent Activity</h6>
                                <!-- Recent activity content here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>



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


        <button class="about-backtotop" onclick="window.scrollTo({top:0,behavior:'smooth'})" title="Back to Top"
            style="display:none;">
            &uarr;
        </button>




    </div>



    <footer class="footer mt-auto">
        <div class="container text-center py-4">
            <p class="mb-0" style="color: #123c63;">&copy; 2025 ArcGuide. All rights reserved.</p>
            <p class="mb-0" style="color: #123c63;">Made with ❤️ by EGDD</p>
        </div>
    </footer>
    <script src="../assets/bootstrap-5.3.3-dist/js/bootstrap.bundle.js"></script>
    <script src="../assets/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.getElementById('sidebarToggler').addEventListener('click', function () {
            var sidebar = document.getElementById('sidebar');
            var content = document.querySelector('.content');
            sidebar.classList.toggle('collapsed');
            if (sidebar.classList.contains('collapsed')) {
                content.style.marginLeft = '60px';
            } else {
                content.style.marginLeft = '260px';
            }
        });

    </script>
    </body>

</html>