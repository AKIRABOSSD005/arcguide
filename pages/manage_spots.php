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

    .btn-search {
        border-radius: 10px;
        background-color: #114f89;
        border-color: #114f89;
        color: #fff;
        transition: all 0.3s ease;
    }

    .btn-search:hover {
        background-color: #46b07d;
        border-color: #46b07d;
        color: #fff;
    }

    .btn-reset {
        border-radius: 10px;
        background-color: #114f89;
        border-color: #114f89;
        color: #fff;
        transition: all 0.3s ease;
    }

    .btn-reset:hover {
        background-color: #46b07d;
        border-color: #46b07d;
        color: #fff;
    }

    .pagination .page-link {
        color: white;
        /* text color */
        background-color: #114f89;
        /* Bootstrap primary blue */
        border-color: #114f89;
    }

    .pagination .page-link:hover {
        background-color: #46b07d;
        border-color: #46b07d;
    }

    /* CUSTOM CSS FOR MODAL */
    /* HEADER COLOR */
    .modal-header.gradient-header {
        background: linear-gradient(135deg, #114f89, #46b07d);
        color: #fff;
        /* make text white for contrast */
    }

    #editModal .modal-dialog {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        /* Full viewport height */
    }


    #editModal .nav-tabs .nav-link.active {
        background-color: #46b07d;
        color: #fff !important;
        border-color: #46b07d #46b07d #fff;
        font-weight: 600;
    }

    /* Hover state */
    #editModal .nav-tabs .nav-link:hover {
        color: #46b07d;
    }

    /* Force modal width */
#editModal .modal-dialog {
    max-width: 1000px;   /* or px/vw value you want */
    width: 1000px;       /* fixed width */
}

/* Lock modal body height */
#editModal .modal-body {
    min-height: 500px;    /* minimum height */
    max-height: 70vh;     /* responsive max height */
    overflow-y: auto;     /* scroll if content too tall */
}

/* Keep all tab panes equal size */
#editModal .tab-content {
    height: 100%;
}

#editModal .tab-pane {
    min-height: 500px;   /* match modal-body */
    height: 100%;
}


    /* BUTTON STYLES */
    .custom-btn {
        background-color: #114f89;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
        border-radius: 8px;
        padding: 8px 18px;
        border: none;
    }

    .custom-btn:hover {
        background-color: #46b07d;
        color: #fff;
        transform: scale(1.05);
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
                    <div class="row g-4 mx-3 mb-4 py-4 align-items-stretch">
                        <!-- Left Column: Form -->
                        <div class="col-lg-6 d-flex">
                            <div class="card shadow-sm border-0 rounded w-100 h-100">
                                <div class="card-body">
                                    <h5 class="card-title fw-semibold">➕ Add New Tourist Spot</h5>
                                    <form id="spotForm" method="POST" action="add_spot.php"
                                        enctype="multipart/form-data" oninput="updatePreview()">
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
                                                <textarea class="form-control" id="description" name="description"
                                                    rows="3" placeholder="Write a short description"
                                                    required></textarea>
                                            </div>

                                            <!-- Image Upload -->
                                            <div class="col-md-6">
                                                <label class="form-label">Image Upload</label>
                                                <input type="file" class="form-control" id="image" name="image"
                                                    accept="image/*" required>
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
                        </div>

                        <!-- Right Column: Live Preview -->
                        <div class="col-lg-6 d-flex">
                            <div class="card shadow-sm border-0 rounded w-100 h-100 d-flex flex-column">
                                <div class="card-header bg-white border-0">
                                    <h5 class="mb-0">🔍 Live Preview</h5>
                                </div>
                                <div class="card-body flex-grow-1 d-flex">
                                    <iframe id="preview" src="spots.php?preview=true" width="100%" height="100%"
                                        frameborder="0"
                                        style="border-radius: 8px; background:#fafafa; min-height:400px;"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>



                    <?php include '../functions/manage_spotsTable.php'; ?>

                    <!-- Search Form -->
                    <form method="GET" class="d-flex justify-content-end mb-3 mx-5 gap-2" id="searchForm">
                        <!-- Filter Type -->
                        <select name="filter" id="filterInput" class="form-select w-auto">
                            <option value="">All Fields</option>
                            <option value="name" <?= isset($_GET['filter']) && $_GET['filter'] == 'name' ? 'selected' : '' ?>>Name</option>
                            <option value="description" <?= isset($_GET['filter']) && $_GET['filter'] == 'description' ? 'selected' : '' ?>>Description</option>
                            <option value="address" <?= isset($_GET['filter']) && $_GET['filter'] == 'address' ? 'selected' : '' ?>>Address</option>
                            <option value="category" <?= isset($_GET['filter']) && $_GET['filter'] == 'category' ? 'selected' : '' ?>>Category</option>
                        </select>

                        <!-- Search Box -->
                        <input type="text" name="search" id="searchInput" class="form-control w-25"
                            placeholder="Search..." value="<?= htmlspecialchars($search ?? '') ?>">

                        <!-- Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn-search">Search</button>
                            <button type="button" class="btn-reset" onclick="resetFilters()">Reset</button>
                        </div>
                    </form>

                    <!-- List of Tourist Spots -->
                    <div class="card mx-5 shadow-sm border-0 rounded mb-5">
                        <div class="card-body">
                            <h5 class="card-title fw-semibold">📍 Existing Tourist Spots</h5>
                            <table class="table table-hover align-middle table-striped" id="spotsTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Location</th>
                                        <th>Category</th>
                                        <th>Rating</th>
                                        <th>Google Maps</th>
                                        <th>Created</th>
                                        <th>Updated</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($spots)): ?>
                                        <?php $count = $offset + 1; ?>
                                        <?php foreach ($spots as $row): ?>
                                            <tr>
                                                <td><?= $count++; ?></td>
                                                <td>
                                                    <?php if (!empty($row['image'])): ?>
                                                        <img src="<?= htmlspecialchars($row['image']); ?>" alt="Spot Image"
                                                            class="img-thumbnail" width="60">
                                                    <?php else: ?>
                                                        <span class="text-muted">No Image</span>
                                                    <?php endif; ?>
                                                </td>

                                                <td><?= htmlspecialchars($row['name']); ?></td>
                                                <td><?= htmlspecialchars($row['description']); ?></td>
                                                <td><?= htmlspecialchars($row['address']); ?></td>
                                                <td><?= htmlspecialchars($row['category']); ?></td>
                                                <td>
                                                    ⭐ <?= number_format($row['avg_rating'], 1); ?>
                                                    (<?= $row['total_reviews']; ?> reviews)
                                                </td>
                                                <td>
                                                    <?php if (!empty($row['google_maps_url'])): ?>
                                                        <a href="<?= htmlspecialchars($row['google_maps_url']); ?>" target="_blank">
                                                            View Map
                                                        </a>
                                                    <?php else: ?>
                                                        <span class="text-muted">N/A</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= htmlspecialchars($row['created_at']); ?></td>
                                                <td><?= htmlspecialchars($row['updated_at']); ?></td>
                                                <td>
                                                    <div class="d-flex justify-content-center gap-2">
                                                        <button class="btn btn-sm btn-warning">
                                                            <i class="bi bi-pencil"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="11" class="text-center">No tourist spots found</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                            <!-- Pagination -->
                            <nav>
                                <ul class="pagination justify-content-center d-flex gap-2">
                                    <?php if ($page > 1): ?>
                                        <li class="page-item">
                                            <a class="page-link"
                                                href="?page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>">Previous</a>
                                        </li>
                                    <?php endif; ?>

                                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                        <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                            <a class="page-link"
                                                href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
                                        </li>
                                    <?php endfor; ?>

                                    <?php if ($page < $totalPages): ?>
                                        <li class="page-item">
                                            <a class="page-link"
                                                href="?page=<?= $page + 1 ?>&search=<?= urlencode($search) ?>">Next</a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <!-- End of List Section -->
                    <br><br>
                </div>
        </main>


        <!-- ================= EDIT MODAL ================= -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                <form method="POST" action="../functions/edit_spot.php" enctype="multipart/form-data">
                    <div class="modal-content border-0 shadow-lg rounded-4">

                        <!-- HEADER -->
                        <div class="modal-header gradient-header text-white rounded-top-4">
                            <h5 class="modal-title fw-bold" id="editModalLabel">✏️ Edit Tourist Spot</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>

                        <!-- BODY with Tabs -->
                        <div class="modal-body">

                            <!-- Nav Tabs -->
                            <ul class="nav nav-tabs mb-3" id="editSpotTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="details-tab" data-bs-toggle="tab"
                                        data-bs-target="#details-tab-pane" type="button" role="tab">Details</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="general-tab" data-bs-toggle="tab"
                                        data-bs-target="#general-tab-pane" type="button" role="tab">General
                                        Info</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="faqs-tab" data-bs-toggle="tab"
                                        data-bs-target="#faqs-tab-pane" type="button" role="tab">FAQs</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="tips-tab" data-bs-toggle="tab"
                                        data-bs-target="#tips-tab-pane" type="button" role="tab">Tips</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="summary-tab" data-bs-toggle="tab"
                                        data-bs-target="#summary-tab-pane" type="button" role="tab">Summary</button>
                                </li>
                            </ul>

                            <!-- Tab Content -->
                            <div class="tab-content" id="editSpotTabsContent">

                                <!-- Details Tab -->
                                <div class="tab-pane fade show active" id="details-tab-pane" role="tabpanel">
                                    <input type="hidden" name="id" id="edit-id">
                                    <div class="row g-3">
                                        <!-- Left -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Name</label>
                                                <input type="text" name="name" id="edit-name" class="form-control"
                                                    required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Description</label>
                                                <textarea name="description" id="edit-description" class="form-control"
                                                    rows="4" required></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Location</label>
                                                <input type="text" name="address" id="edit-address" class="form-control"
                                                    required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Category</label>
                                                <select name="category_id" id="edit-category" class="form-select"
                                                    required>
                                                    <option value="">-- Select Category --</option>
                                                    <?php
                                                    $catSql = "SELECT id, name FROM spot_categories ORDER BY name ASC";
                                                    $catResult = $conn->query($catSql);
                                                    while ($cat = $catResult->fetch_assoc()): ?>
                                                        <option value="<?= $cat['id']; ?>">
                                                            <?= htmlspecialchars($cat['name']); ?>
                                                        </option>
                                                    <?php endwhile; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- Right -->
                                        <div class="col-md-6">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold">Latitude</label>
                                                    <input type="text" name="latitude" id="edit-latitude"
                                                        class="form-control" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold">Longitude</label>
                                                    <input type="text" name="longitude" id="edit-longitude"
                                                        class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="mb-3 mt-3">
                                                <label class="form-label fw-semibold">Google Maps URL</label>
                                                <input type="url" name="google_maps_url" id="edit-maps"
                                                    class="form-control">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Images</label>
                                                <div id="current-images" class="mb-2 d-flex flex-wrap gap-2"></div>
                                                <input type="file" name="images[]" class="form-control" multiple
                                                    onchange="previewNewImages(event)">
                                                <small class="text-muted">Upload new images to replace/add to this
                                                    spot.</small>
                                                <div id="new-images-preview" class="d-flex flex-wrap gap-2 mt-2"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- General Info Tab -->
                                <div class="tab-pane fade" id="general-tab-pane" role="tabpanel">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Location Details</label>
                                        <input type="text" name="gen_location" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Significance</label>
                                        <textarea name="gen_significance" class="form-control" rows="3"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Structure</label>
                                        <textarea name="gen_structure" class="form-control" rows="3"></textarea>
                                    </div>
                                </div>

                                <!-- FAQs Tab -->
                                <div class="tab-pane fade" id="faqs-tab-pane" role="tabpanel">
                                    <div id="faqs-container">
                                        <div class="faq-item mb-3">
                                            <label class="form-label fw-semibold">Question</label>
                                            <input type="text" name="faq_question[]" class="form-control">
                                            <label class="form-label fw-semibold mt-2">Answer</label>
                                            <textarea name="faq_answer[]" class="form-control" rows="2"></textarea>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-outline-primary btn-sm mt-2"
                                        onclick="addFaq()">+ Add FAQ</button>
                                </div>

                                <!-- Tips Tab -->
                                <div class="tab-pane fade" id="tips-tab-pane" role="tabpanel">
                                    <div id="tips-container">
                                        <div class="tip-item mb-2">
                                            <input type="text" name="tips[]" class="form-control"
                                                placeholder="Enter a tip">
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-outline-success btn-sm mt-2"
                                        onclick="addTip()">+ Add Tip</button>
                                </div>

                                <!-- Summary Tab -->
                                <div class="tab-pane fade" id="summary-tab-pane" role="tabpanel">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Summary</label>
                                        <textarea name="summary" class="form-control" rows="4"></textarea>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- FOOTER -->
                        <div class="modal-footer d-flex justify-content-between">
                            <button type="button" class="btn btn-outline-secondary"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn custom-btn">💾 Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <!-- ================= DELETE MODAL ================= -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg rounded-4">
                    <!-- HEADER -->
                    <div class="modal-header gradient-header bg-danger text-white rounded-top-4 mb-3">
                        <h5 class="modal-title fw-bold" id="deleteModalLabel">🗑️ Delete Tourist Spot</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <!-- FORM -->
                    <form method="POST" action="delete_spot.php">
                        <!-- BODY -->
                        <div class="modal-body text-center mb-3">
                            <input type="hidden" name="id" id="delete-id">
                            <p class="fs-6 mb-0">
                                Are you sure you want to delete this tourist spot? <br>
                                <strong class="text-danger">This action cannot be undone.</strong>
                            </p>
                        </div>
                        <!-- FOOTER -->
                        <div class="modal-footer d-flex justify-content-between">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">No</button>
                            <button type="submit" class="btn btn-danger">✅ Yes, Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- Logout Confirmation Modal -->
        <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header ">
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

    <button class="about-backtotop" onclick="window.scrollTo({top:0,behavior:'smooth'})" title="Back to Top"
        style="display:none;">
        &uarr;
    </button>

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

    <!-- Script to EDit SPOTS modal -->
    <script>
        function previewNewImages(event) {
            const previewContainer = document.getElementById('new-images-preview');
            previewContainer.innerHTML = ""; // Clear old previews

            const files = event.target.files;
            if (files) {
                [...files].forEach(file => {
                    const reader = new FileReader();
                    reader.onload = e => {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.classList.add('img-thumbnail');
                        img.style.width = "80px";
                        img.style.height = "80px";
                        previewContainer.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                });
            }
        }

        // ===== Button Click to Open Edit Modal =====
        document.querySelectorAll('.btn-warning').forEach(button => {
            button.addEventListener('click', function () {
                const spotId = this.closest('tr').querySelector('td:first-child').textContent.trim();

                fetch(`../functions/get_spots_details.php?id=${spotId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            alert(data.error);
                            return;
                        }

                        // --- Fill basic info ---
                        document.getElementById('edit-id').value = data.spot.id;
                        document.getElementById('edit-name').value = data.spot.name;
                        document.getElementById('edit-description').value = data.spot.description;
                        document.getElementById('edit-address').value = data.spot.address || '';
                        document.getElementById('edit-latitude').value = data.spot.latitude || '';
                        document.getElementById('edit-longitude').value = data.spot.longitude || '';
                        document.getElementById('edit-maps').value = data.spot.google_maps_url || '';
                        document.getElementById('edit-category').value = data.spot.category_id || '';

                        // --- General Info ---
                        document.querySelector('[name="gen_location"]').value = data.general?.location || '';
                        document.querySelector('[name="gen_significance"]').value = data.general?.significance || '';
                        document.querySelector('[name="gen_structure"]').value = data.general?.structure || '';

                        // --- FAQs ---
                        const faqContainer = document.getElementById('faqs-container');
                        faqContainer.innerHTML = "";
                        if (data.faqs && data.faqs.length > 0) {
                            data.faqs.forEach(faq => {
                                const faqItem = document.createElement('div');
                                faqItem.classList.add('faq-item', 'mb-3');
                                faqItem.innerHTML = `
                                <label class="form-label fw-semibold">Question</label>
                                <input type="text" name="faq_question[]" class="form-control" value="${faq.question}">
                                <label class="form-label fw-semibold mt-2">Answer</label>
                                <textarea name="faq_answer[]" class="form-control" rows="2">${faq.answer}</textarea>
                            `;
                                faqContainer.appendChild(faqItem);
                            });
                        } else {
                            addFaq(); // at least one blank
                        }

                        // --- Tips ---
                        const tipsContainer = document.getElementById('tips-container');
                        tipsContainer.innerHTML = "";
                        if (data.tips && data.tips.length > 0) {
                            data.tips.forEach(tip => {
                                const tipItem = document.createElement('div');
                                tipItem.classList.add('tip-item', 'mb-2');
                                tipItem.innerHTML = `<input type="text" name="tips[]" class="form-control" value="${tip}">`;
                                tipsContainer.appendChild(tipItem);
                            });
                        } else {
                            addTip();
                        }

                        // --- Summary ---
                        document.querySelector('[name="summary"]').value = data.summary || '';

                        // Finally open modal
                        var editModal = new bootstrap.Modal(document.getElementById('editModal'));
                        editModal.show();
                    })
                    .catch(err => {
                        console.error("Error fetching spot details:", err);
                        alert("Failed to load spot details.");
                    });
            });
        });

        // ===== Button Click to Open Delete Modal =====
        document.querySelectorAll('.btn-danger').forEach(button => {
            button.addEventListener('click', function () {
                var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
                deleteModal.show();
            });
        });

        function addFaq() {
            const container = document.getElementById('faqs-container');
            const faqItem = document.createElement('div');
            faqItem.classList.add('faq-item', 'mb-3');
            faqItem.innerHTML = `
            <label class="form-label fw-semibold">Question</label>
            <input type="text" name="faq_question[]" class="form-control">
            <label class="form-label fw-semibold mt-2">Answer</label>
            <textarea name="faq_answer[]" class="form-control" rows="2"></textarea>
        `;
            container.appendChild(faqItem);
        }

        function addTip() {
            const container = document.getElementById('tips-container');
            const tipItem = document.createElement('div');
            tipItem.classList.add('tip-item', 'mb-2');
            tipItem.innerHTML = `<input type="text" name="tips[]" class="form-control" placeholder="Enter a tip">`;
            container.appendChild(tipItem);
        }
    </script>


    <!-- Script -->
    <script>
        // Reset filter + search + refresh clean URL
        function resetFilters() {
            const filter = document.getElementById('filterInput');
            const search = document.getElementById('searchInput');

            if (filter) filter.value = "";
            if (search) search.value = "";

            // Redirect to clean page without query params
            window.location.href = "manage_spots.php";
        }

        // Auto submit when filter dropdown changes
        document.getElementById('filterInput').addEventListener('change', function () {
            document.getElementById('searchForm').submit();
        });
    </script>

</body>

</html>