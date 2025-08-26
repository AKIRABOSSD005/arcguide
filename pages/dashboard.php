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
    <style>
        body {
            background: #f5f5f5;
        }

        .about-backtotop {
            position: fixed;
            bottom: 32px;
            right: 32px;
            z-index: 999;
            background: #114f89;
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            box-shadow: 0 2px 8px rgba(18, 60, 99, 0.15);
            cursor: pointer;
            opacity: 0.85;
            transition: background 0.2s, opacity 0.2s;
        }

        .about-backtotop:hover {
            background: #46b07d;
            opacity: 1;
        }


        .wrapper {
            min-height: 100vh;
            display: flex;
        }

        /* ==== SIDEBAR ==== */
        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 260px;
            background: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 0;
            z-index: 100;
            transition: width 0.3s;
        }

        .sidebar.collapsed {
            width: 60px;
            align-items: flex-start;
        }

        /* Sidebar Logo */
        .sidebar-logo {
            width: 100%;
            text-align: center;
            padding: 24px 0 8px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: padding 0.3s;
            cursor: pointer;
        }

        .sidebar.collapsed .sidebar-logo {
            padding: 16px 0 0;
            text-align: left;
            width: 60px;
        }

        .logo-full {
            width: 120px;
            margin-bottom: 8px;
            display: block;
            transition: all 0.3s;
            cursor: pointer;
        }

        .logo-mini {
            width: 40px;
            margin-bottom: 8px;
            display: none;
            transition: all 0.3s;
            cursor: pointer;
        }

        .sidebar.collapsed .logo-full {
            display: none;
        }

        .sidebar.collapsed .logo-mini {
            display: block;
            margin-left: 10px;
        }

        /* Sidebar Toggler */
        .sidebar-toggler-box {
            position: absolute;
            top: 60px;
            left: 100%;
            transform: translateX(-50%);
            background: #114f89;
            border-radius: 6px;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
            cursor: pointer;
            z-index: 101;
            transition: left 0.3s, background 0.2s;
        }

        .sidebar-toggler-box:hover {
            background: #46b07d;
        }

        .sidebar-toggler-box .bi-list {
            color: #fff;
            font-size: 1.5rem;
        }

        .sidebar.collapsed .sidebar-toggler-box {
            left: 60px;
            top: 16px;
            transform: none;
        }

        /* Sidebar Nav */
        .sidebar-nav {
            margin-top: 32px;
            width: 100%;
            padding-left: 0;
            transition: margin-top 0.3s;
        }

        .sidebar.collapsed .sidebar-nav {
            margin-top: 80px;
            width: 60px;
        }

        .sidebar-item {
            width: 100%;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 12px 32px;
            color: #114f89;
            font-weight: 500;
            text-decoration: none;
            transition: background 0.2s, padding 0.3s, color 0.2s;
            white-space: nowrap;
        }

        .sidebar-link.active,
        .sidebar-link:hover {
            background: #e3e3e3;
            color: #46b07d !important;
        }

        .sidebar-link i {
            margin-right: 12px;
            font-size: 1.2rem;
            min-width: 24px;
            text-align: center;
            color: inherit;
        }

        .sidebar.collapsed .sidebar-link {
            justify-content: center;
            padding: 12px 0;
            width: 60px;
        }

        .sidebar.collapsed .sidebar-link i {
            margin-right: 0;
        }

        .sidebar.collapsed .sidebar-link span {
            display: none;
        }

        /* ==== FOOTER ==== */
        .footer {
            width: 100%;
            background: #fff;
            border-top: 1px solid #eee;
            position: fixed;
            left: 0;
            bottom: 0;
            z-index: 99;
            padding: 12px 16px;
            text-align: center;
        }

        /* Tablet and smaller - footer becomes static to avoid overlap */
        @media (max-width: 991.98px) {
            .footer {
                position: relative;
                bottom: auto;
                left: auto;
            }
        }

        /* Mobile - smaller padding for compact space */
        @media (max-width: 575.98px) {
            .footer {
                padding: 8px 12px;
                font-size: 0.9rem;
            }

            .dashboard-header {
                flex-direction: column !important;
                text-align: center !important;
                align-items: center !important;
                margin: 0 !important;
                padding: 16px !important;
                width: 100% !important;
                gap: 8px !important;

            }

            .dashboard-header h5 {
                width: 100%;
                margin-bottom: 8px;
            }

            .dashboard-header>div {
                justify-content: center !important;
            }

            .about-backtotop {
                bottom: 16px;
                right: 16px;
                width: 40px;
                height: 40px;
                font-size: 1.2rem;
            }
        }


        .waving-hand {
            display: inline-block;
            animation: wave 1s ease-in-out 0s 3;
            transform-origin: 70% 70%;
        }

        @keyframes wave {
            0% {
                transform: rotate(0deg);
            }

            15% {
                transform: rotate(20deg);
            }

            30% {
                transform: rotate(-10deg);
            }

            45% {
                transform: rotate(20deg);
            }

            60% {
                transform: rotate(-5deg);
            }

            75% {
                transform: rotate(10deg);
            }

            100% {
                transform: rotate(0deg);
            }
        }
    </style>

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
                    $mapPinsCount = isset($pinLocations) ? count($pinLocations) : 0;
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
                                    style="width:40px;height:40px;margin-bottom:8px;">
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
                                <!-- Chart or content here -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body">
                                <h6 class="card-title mb-2">Tourists Spot by Category</h6>
                                <!-- Chart or content here -->
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