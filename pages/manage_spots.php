<?php
require '../config/nocache.php';
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
    <title>ArcGuide: Manage Tourist Spots</title>
    <link rel="icon" type="image/svg+xml" href="../assets/icons/logo.svg">
    <link rel="stylesheet" href="../assets/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.lineicons.com/4.0/lineicons.css">
</head>
<style>
    .spot-icon {
        color: #114f89;
        transition: color 0.3s ease;
    }

    .spot-icon:hover {
        color: #46b07d;
    }

    .btn-custom {
        background-color: #114f89;
        border-color: #114f89;
        color: #fff;
        transition: all 0.3s ease;
    }

    .btn-custom:hover {
        background-color: #46b07d;
        border-color: #46b07d;
        color: #fff;
    }
</style>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
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
                    <a href="dashboard.php" class="sidebar-link">
                        <i class="lni lni-bar-chart"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="manage_spots.php" class="sidebar-link active">
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

        <!-- Main Content -->
        <main class="content flex-grow-1" style="margin-left:260px; transition:margin-left 0.3s;">
            <div class="container-fluid py-4">
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap mx-5 dashboard-header">
                    <h5 class="fw-semibold mb-0">
                        Manage Tourists Spots <i class="bi bi-image-alt spot-icon"></i>
                    </h5>
                    <div class="d-flex align-items-center gap-2">
                        <span class="fw-semibold mt-2">
                            <?php echo htmlspecialchars($_SESSION['user']['name'] ?? 'Guest'); ?>
                        </span>

                        <img src="<?= htmlspecialchars($_SESSION['user']['picture']) ?>" alt="Profile"
                            class="rounded-circle" width="36" height="36" style="object-fit: cover; cursor:pointer;"
                            data-bs-toggle="modal" data-bs-target="#logoutModal">
                    </div>
                </div>

                <!-- Form Section -->
                <div class="card mx-5 mb-4 shadow-sm border-0 rounded">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold">➕ Add New Tourist Spot</h5>
                        <form id="spotForm" method="POST" action="add_spot.php" enctype="multipart/form-data"
                            oninput="updatePreview()">
                            <div class="row g-3">
                                <!-- Spot Name -->
                                <div class="col-md-6">
                                    <label class="form-label">Spot Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Enter spot name" required>
                                </div>

                                <!-- Location -->
                                <div class="col-md-6">
                                    <label class="form-label">Location</label>
                                    <input type="text" class="form-control" id="location" name="location"
                                        placeholder="Enter location" required>
                                </div>

                                <!-- Description -->
                                <div class="col-md-12">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="3"
                                        placeholder="Write a short description" required></textarea>
                                </div>

                                <!-- Image Upload -->
                                <div class="col-md-6">
                                    <label class="form-label">Image Upload</label>
                                    <input type="file" class="form-control" id="image" name="image" accept="image/*"
                                        required>
                                </div>

                                <!-- Category -->
                                <div class="col-md-6">
                                    <label class="form-label">Category</label>
                                    <select id="category" name="category" class="form-select" required>
                                        <option value="">Choose category</option>
                                        <option value="1">Historical</option>
                                        <option value="2">Religious</option>
                                        <option value="3">Natural</option>
                                        <option value="4">Resort</option>
                                        <option value="5">Cave</option>
                                        <option value="6">Mountain</option>
                                        <option value="7">River</option>
                                        <option value="8">Falls</option>
                                        <option value="9">Landmark</option>
                                        <option value="10">Heritage House</option>
                                    </select>

                                </div>

                                <!-- Latitude -->
                                <div class="col-md-6">
                                    <label class="form-label">Latitude</label>
                                    <input type="text" class="form-control" id="latitude" name="latitude"
                                        placeholder="Enter latitude (e.g. 15.123456)" required>
                                </div>

                                <!-- Longitude -->
                                <div class="col-md-6">
                                    <label class="form-label">Longitude</label>
                                    <input type="text" class="form-control" id="longitude" name="longitude"
                                        placeholder="Enter longitude (e.g. 120.987654)" required>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="mt-3 text-center">
                                <button type="submit" class="btn btn-custom">
                                    <i class="bi bi-save"></i> Save Spot
                                </button>
                            </div>
                        </form>

                    </div>
                </div>

                <!-- Live Preview Card -->
                <div class="card shadow-sm mx-5 mb-4" style="border-radius: 12px;">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0">🔍 Live Preview</h5>
                    </div>
                    <div class="card-body">
                        <iframe id="preview" src="spots.php?preview=true" width="100%" height="280px" frameborder="0"
                            style="border-radius: 8px; background:#fafafa;"></iframe>
                    </div>
                </div>


                <!-- List of Tourist Spots -->
                <div class="card mx-5 shadow-sm border-0 rounded mb-5">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold">📍 Existing Tourist Spots</h5>
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Location</th>
                                    <th>Category</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Example data (replace with PHP loop later) -->
                                <tr>
                                    <td>1</td>
                                    <td>San Miguel Church</td>
                                    <td>Poblacion, San Miguel</td>
                                    <td>Religious</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></button>
                                        <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Biak-na-Bato National Park</td>
                                    <td>San Miguel, Bulacan</td>
                                    <td>Nature</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></button>
                                        <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <br><br>

            </div>
        </main>

        <!-- Logout Confirmation Modal -->
        <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-dark" id="logoutModalLabel">Logout Confirmation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
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
    </div>

    <footer class="footer mt-auto">
        <div class="container text-center py-2">
            <p class="mb-0" style="color: #123c63;">&copy; 2025 ArcGuide. All rights reserved.</p>
            <p class="mb-0" style="color: #123c63;">Made with ❤️ by EGDD</p>
        </div>
    </footer>

    <script src="../assets/bootstrap-5.3.3-dist/js/bootstrap.bundle.js"></script>
    <script src="../assets/js/script.js"></script>

    <script>
        // Sidebar Toggle
        document.getElementById('sidebarToggler').addEventListener('click', function () {
            var sidebar = document.getElementById('sidebar');
            var content = document.querySelector('.content');
            sidebar.classList.toggle('collapsed');
            content.style.marginLeft = sidebar.classList.contains('collapsed') ? '60px' : '260px';
        });

        // Live Preview
        function updatePreview() {
            const name = document.getElementById('name').value;
            const description = document.getElementById('description').value;
            const location = document.getElementById('location').value;
            const category = document.getElementById('category').value;

            const iframe = document.getElementById('preview');
            iframe.src = `spots.php?preview=true&name=${encodeURIComponent(name)}&description=${encodeURIComponent(description)}&location=${encodeURIComponent(location)}&category=${encodeURIComponent(category)}`;
        }
    </script>
</body>

</html>