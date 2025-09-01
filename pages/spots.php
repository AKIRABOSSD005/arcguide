<?php
require '../config/nocache.php';
require_once '../functions/spotsData.php';
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
  <title>Tourists Spots in San Miguel Bulacan| ArcGuide</title>
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

    <main class="main py-5" style="background: #f8f5ee;">
      <div class="container">
        <!-- Header -->
        <div class="text-center mb-5">
          <img src="../assets/icons/map.svg" alt="Map Icon" style="width: 40px; height: 40px;">
          <h1 class="fw-bold mt-2" style="color: #114f89;">Tourist Spots</h1>
          <p class="lead text-muted mb-0">Discover the top attractions and landmarks</p>
        </div>

        <!-- Top Attractions -->
        <h2 class="fw-bold mb-4" style="color: #123c63;">Top Attractions</h2>
        <div class="row g-4">
          <?php foreach ($spots as $i => $spot): ?>
            <div class="col-12 col-md-6 col-lg-4">
              <div class="card h-100 border-0 shadow-sm rounded-4 spot-card fade-in" style="cursor:pointer;"
                data-bs-toggle="modal" data-bs-target="#spotModal" 
                data-id="<?php echo $spot['id']; ?>"
                data-title="<?php echo $spot['title']; ?>" 
                data-image="../<?php echo $spot['image']; ?>"
                data-description="<?php echo htmlspecialchars($spot['description']); ?>">

                <div class="overflow-hidden rounded-top-4">
                  <img src="../<?php echo $spot['image']; ?>" class="card-img-top spot-img"
                    alt="<?php echo $spot['title']; ?>"
                    style="object-fit: cover; height: 180px; transition: transform 0.3s;">
                </div>
                <div class="card-body">
                  <h5 class="card-title fw-bold" style="color: #114f89;"><?php echo $spot['title']; ?></h5>
                  <p class="card-text text-muted mb-0"><?php echo $spot['description']; ?></p>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Modal for spot details -->
      <div class="modal fade" id="spotModal" tabindex="-1" aria-labelledby="spotModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content rounded-4">
            <div class="modal-header border-0">
              <h5 class="modal-title fw-bold" id="spotModalLabel"></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
              <img id="spotModalImg" src="" alt="" class="img-fluid rounded-4 mb-3"
                style="max-height:320px;object-fit:cover;">
              <div id="spotModalDesc" class="text-start"></div>
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
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#114f89" class="bi bi-person-circle"
                viewBox="0 0 16 16">
                <path d="M11 10a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 1 0 0 14A7 7 0 0 0 8 1z" />
              </svg>
            </div>
            <!-- Message -->
            <div class="toast-body fs-6 text-dark pe-2">
              You are browsing as a guest.
            </div>
            <!-- Close Button -->
            <button type="button" class="btn-close ms-auto me-1" data-bs-dismiss="toast" aria-label="Close"></button>
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

  <!-- Modal Spots INFOS -->
  <script>
    const spotModal = document.getElementById('spotModal');

    spotModal.addEventListener('show.bs.modal', function (event) {
      var card = event.relatedTarget; // the clicked card/button

      var spotId = card.getAttribute('data-id');
      var title = card.getAttribute('data-title');
      var image = card.getAttribute('data-image');

      // Basic UI (title + image)
      document.getElementById('spotModalLabel').textContent = title;
      document.getElementById('spotModalImg').src = image;
      document.getElementById('spotModalImg').alt = title;

      // Clear previous content
      const descContainer = document.getElementById('spotModalDesc');
      descContainer.innerHTML = "<p class='text-muted'>Loading details...</p>";

      // Fetch details from backend
      fetch(`../functions/get_spots_details.php?id=${spotId}`)
        .then(res => res.json())
        .then(data => {
          let html = "";

          // --- General Info ---
          if (data.general) {
            html += `<h6 class="fw-bold mt-3">ℹ️ General Info</h6>`;
            if (data.general.location) html += `<p><strong>Location:</strong> ${data.general.location}</p>`;
            if (data.general.significance) html += `<p><strong>Significance:</strong> ${data.general.significance}</p>`;
            if (data.general.structure) html += `<p><strong>Structure:</strong> ${data.general.structure}</p>`;
          }

          // --- FAQs ---
          if (data.faqs && data.faqs.length > 0) {
            html += `<h6 class="fw-bold mt-3">🎯 FAQs</h6><ol>`;
            data.faqs.forEach(faq => {
              html += `<li><strong>${faq.question}</strong><br>${faq.answer}</li>`;
            });
            html += `</ol>`;
          }

          // --- Tips ---
          if (data.tips && data.tips.length > 0) {
            html += `<h6 class="fw-bold mt-3">💡 Tips for Visitors</h6><ul>`;
            data.tips.forEach(tip => {
              html += `<li>${tip}</li>`; // since backend sends just strings
            });
            html += `</ul>`;
          }

          // --- Summary ---
          if (data.summary) {
            html += `<h6 class="fw-bold mt-3">📌 Summary</h6><p>${data.summary}</p>`;
          }

          descContainer.innerHTML = html || "<p>No details available.</p>";
        })
        .catch(err => {
          console.error("Error fetching spot details:", err);
          descContainer.innerHTML = "<p class='text-danger'>Failed to load details.</p>";
        });
    });
  </script>



</body>

</html>