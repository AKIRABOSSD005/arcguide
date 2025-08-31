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
                data-bs-toggle="modal" data-bs-target="#spotModal" data-title="<?php echo $spot['title']; ?>"
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
    // Rich content data
    const spotDescriptions = {
      'San Miguel Welcome Arch Monument': `
            <h6 class="fw-bold">🏛️ Description & Significance</h6>
            <p>The San Miguel Welcome Arch—also known as the <em>San Miguel Boundary Arch</em>—marks the gateway between San Ildefonso and San Miguel, Bulacan. It features a statue of Saint Michael slaying evil, a symbol of community pride and devotion.</p>

            <h6 class="fw-bold mt-4">ℹ️ General Info</h6>
            <ul>
                <li><strong>Location:</strong> Pan‑Philippine Hwy, Brgy. Salangan, San Miguel, Bulacan (15.1186° N, 120.9482° E)</li>
                <li><strong>Significance:</strong> Cultural and religious landmark marking municipal boundary</li>
                <li><strong>Structure:</strong> Earth-toned pillars, central arch, topped with a statue of Saint Michael</li>
            </ul>

            <h6 class="fw-bold mt-4">🎯 FAQs</h6>
            <ol>
                <li><strong>Fee to visit?</strong> None. It’s a public roadside monument.</li>
                <li><strong>Photo-friendly?</strong> Yes, but remain cautious near the road.</li>
                <li><strong>Nearby attractions?</strong> San Miguel Arcángel Church, Bahay na Pula</li>
                <li><strong>Best time to visit?</strong> Early morning or late afternoon for cooler temps and good lighting.</li>
                <li><strong>Vendors nearby?</strong> Yes. Small stalls sell chicharon and snacks.</li>
            </ol>

            <h6 class="fw-bold mt-4">💡 Tips for Visitors</h6>
            <ul>
                <li>Use OpenStreetMap code: <strong>4W9X+F78</strong> for accurate GPS directions</li>
                <li>Great for cyclist rest stops and photo ops</li>
                <li>Expect minor road wear but generally clean</li>
            </ul>

            <p class="mt-3 text-muted"><em>This summary is based on top-rated sources and traveler reviews.</em></p>
        `,

      'Diocesan Shrine and Parish of San Miguel Archangel': `
    <h6 class="fw-bold">🏛️ Description & Significance</h6>
    <p>The Diocesan Shrine and Parish of San Miguel Arcangel is a well-preserved Baroque church in San Miguel, Bulacan. Established in 1725 and completed in 1869, it was elevated to shrine status in 2021 in honor of deep devotion to Saint Michael the Archangel.</p>

    <h6 class="fw-bold mt-4">ℹ️ General Info</h6>
    <ul>
        <li><strong>Location:</strong> 138 Buencamino Street, Poblacion, San Miguel, Bulacan</li>
        <li><strong>Contact:</strong> (044) 762‑0172 / 0917‑1029644</li>
        <li><strong>Feast Day:</strong> May 8</li>
        <li><strong>Affiliation:</strong> Diocese of Malolos</li>
    </ul>

    <h6 class="fw-bold mt-4">🏗️ Architecture</h6>
    <ul>
        <li><strong>Style:</strong> Spanish Baroque</li>
        <li><strong>Features:</strong> Two-level stone façade, curved pediment, domed belfry</li>
        <li><strong>Interior:</strong> Classic arched nave with a grand altar dedicated to Saint Michael</li>
    </ul>

    <h6 class="fw-bold mt-4">🎯 FAQs</h6>
    <ol>
        <li><strong>Is it open to the public?</strong> Yes, with no entrance fee</li>
        <li><strong>Mass Schedule?</strong> Sun: 5AM–5PM; Wed/Thu: 6PM; Sat: 7AM</li>
        <li><strong>Founded:</strong> As a visita pre-1607, parish in 1725, shrine in 2021</li>
        <li><strong>Is it a pilgrimage site?</strong> Yes, especially during the Feast of St. Michael</li>
    </ol>

    <h6 class="fw-bold mt-4">💡 Visiting Tips</h6>
    <ul>
        <li>Visit during May for the feast day celebration</li>
        <li>Attend an early morning Mass for a serene experience</li>
        <li>Great photo spot for heritage architecture</li>
    </ul>

    <p class="mt-3 text-muted"><em>This church is not just a religious structure, but a historical icon that continues to inspire faith and community in Bulacan.</em></p>
`,
      'Tecson Ancestral House': `
    <h6 class="fw-bold">🏛️ Description & History</h6>
    <p>The <strong>Tecson Ancestral House</strong> is a historic <em>bahay-na-bato</em> (stone and wood house) located in San Miguel, Bulacan. Built during the Spanish colonial era, it belonged to the influential Tecson family who played key roles in the Philippine Revolution. It served as a meeting venue for the Katipunan and was temporarily used as a headquarters by President Emilio Aguinaldo.</p>

    <h6 class="fw-bold mt-4">ℹ️ General Information</h6>
    <ul>
        <li><strong>Location:</strong> Brgy. San Jose, San Miguel, Bulacan</li>
        <li><strong>Type:</strong> Bahay-na-Bato / Heritage House</li>
        <li><strong>Built:</strong> Late 1800s (Spanish era)</li>
        <li><strong>Declared:</strong> National Historical Landmark by NHCP</li>
        <li><strong>Significance:</strong> Katipunan meeting place; Aguinaldo’s temporary HQ</li>
    </ul>

    <h6 class="fw-bold mt-4">🎯 FAQs</h6>
    <ol>
        <li><strong>Can I visit the Tecson House?</strong> Yes, but access depends on restoration and local arrangements.</li>
        <li><strong>Is there an entrance fee?</strong> Usually none. Some guided tours may request donations.</li>
        <li><strong>What can I expect to see?</strong> Spanish-style design, capiz windows, antique furniture (if open).</li>
        <li><strong>Can I take photos?</strong> Exterior photography is allowed; ask permission inside.</li>
        <li><strong>Why is it important?</strong> It was a revolutionary base and a symbol of heritage.</li>
    </ol>

    <h6 class="fw-bold mt-4">💡 Tips for Visitors</h6>
    <ul>
        <li>Coordinate with local tourism offices for better access</li>
        <li>Respect private property signs—some areas may be off-limits</li>
        <li>Pair your visit with nearby sites like San Miguel Church or Bahay na Pula</li>
        <li>Best viewed during daytime for architectural appreciation</li>
    </ul>

    <p class="mt-3 text-muted"><em>This ancestral house is a legacy of Filipino patriotism and a window into the country's revolutionary past.</em></p>
`,
      'Simon Tecson Historical Marker': `
    <h6 class="fw-bold">🏛️ Description & Significance</h6>
    <p>The <strong>Simon Tecson Historical Marker</strong> commemorates Brigadier General <strong>Simon O. Tecson</strong> (1861–1903), a revolutionary leader from San Miguel. Installed in 2009 by the National Historical Commission of the Philippines, it honors his role in the Philippine Revolution, the Biak‑na‑Bato Pact, the Siege of Baler, and the Filipino‑American War.</p>

    <h6 class="fw-bold mt-4">ℹ️ General Info</h6>
    <ul>
        <li><strong>Location:</strong> Rizal Street (at the left pillar of the original Simon Tecson ancestral house), San Miguel, Bulacan (approx. 15°08′19″ N, 120°58′15″ E) :contentReference[oaicite:1]{index=1}</li>
        <li><strong>Marker Type:</strong> Biographical (Level II historical marker), installed by National Historical Institute in 2009 :contentReference[oaicite:2]{index=2}</li>
        <li><strong>Material:</strong> Cast iron plaque mounted on pillar :contentReference[oaicite:3]{index=3}</li>
        <li><strong>Subject:</strong> Simon Tecson – Katipunan member, signer of Biak‑na‑Bato constitution (1897), led Filipino forces at Baler, fought in Filipino‑American War, exiled to Guam, returned in 1902) :contentReference[oaicite:4]{index=4}</li>
    </ul>

    <h6 class="fw-bold mt-4">🎯 FAQs</h6>
    <ol>
        <li><strong>Who was Simon Tecson?</strong> A Bulacan revolutionary colonel, signed the Biak‑na‑Bato Constitution (1897), led siege efforts at Baler, fought American forces, exiled to Guam, then returned and died in 1903 :contentReference[oaicite:5]{index=5}.</li>
        <li><strong>Where is the marker located?</strong> On Rizal Street, attached to the pillar left of the gate of his ancestral house in San Miguel :contentReference[oaicite:6]{index=6}.</li>
        <li><strong>When was it installed?</strong> 2009, as part of NHCP (formerly NHI) biographical markers project :contentReference[oaicite:7]{index=7}.</li>
        <li><strong>Can you visit it?</strong> Yes, it’s roadside and publicly visible anytime.</li>
        <li><strong>Is there a tour or nearby sites?</strong> It’s just beside the Tecson ancestral house. Nearby attractions include the Tecson House, San Miguel Church, and Biak‑na‑Bato National Park.</li>
    </ol>

    <h6 class="fw-bold mt-4">💡 Visiting Tips</h6>
    <ul>
        <li>Pair your visit with the **Tecson Ancestral House** and **San Miguel Church** for a richer historical experience.</li>
        <li>Look for marker text detailing Tecson’s achievements—useful for history buffs & students.</li>
        <li>Combine with an outdoor trip to **Biak‑na‑Bato**, where Tecson’s revolutionary connections also resound.</li>
        <li>Good for heritage walks along Rizal Street—wear comfortable shoes and bring a camera!</li>
    </ul>
`,
      'Villacorte‑Villaseñor Ancestral House': `
    <h6 class="fw-bold">🏛️ Description & History</h6>
    <p>The <strong>Villacorte‑Villaseñor Ancestral House</strong> is a bahay na bato built around 1905 by Nicholas Villaseñor and Leticia Villacorte. The house features American-era renovations like stained-glass panels and steel ventanillas, blending traditional and colonial styles :contentReference[oaicite:28]{index=28}. It stands on family land where a rice granary once sheltered the Villacorte family during the Filipino-American War—a story still preserved in oral history :contentReference[oaicite:29]{index=29}.</p>

    <h6 class="fw-bold mt-4">ℹ️ General Information</h6>
    <ul>
        <li><strong>Location:</strong> Brgy. San Jose, San Miguel, Bulacan</li>
        <li><strong>Built:</strong> Circa 1905 (American period) :contentReference[oaicite:30]{index=30}</li>
        <li><strong>Style:</strong> Bahay na bato with stained glass and steel ventanillas :contentReference[oaicite:31]{index=31}</li>
        <li><strong>Family History:</strong> Site of wartime shelter during Filipino-American War :contentReference[oaicite:32]{index=32}</li>
    </ul>

    <h6 class="fw-bold mt-4">🎯 FAQs</h6>
    <ol>
        <li><strong>Is it open to the public?</strong> No—but exterior views are visible; interior access depends on homeowner’s permission.</li>
        <li><strong>Entrance fee?</strong> None—any interior walkthroughs are private.</li>
        <li><strong>Why visit?</strong> To appreciate its unique architecture and hear a family's wartime legacy.</li>
        <li><strong>What to see?</strong> Stained-glass windows, steel vents, sturdy stone-wood structure.</li>
    </ol>

    <h6 class="fw-bold mt-4">💡 Visiting Tips</h6>
    <ul>
        <li>Ask for permission if you'd like to go inside</li>
        <li>Best photographed in the morning light</li>
        <li>Combine with nearby heritage sites for a fuller experience</li>
    </ul>

    <p class="mt-3 text-muted"><em>A living testament to family resilience during wartime and the evolving architectural styles of early 20th-century Bulacan.</em></p>
`,
      'Sevilla Ancestral House': `
  <h6 class="fw-bold">🏛️ Description & History</h6>
  <p>The <strong>Sevilla Ancestral House</strong>, also called the "Tatlong Palapag" ("Three Floors"), is a rare 3‑story bahay na bato built in 1921 by ex‑municipal president Catalino Sevilla. It once hosted elite gatherings in its ballroom and was later commandeered by Japanese forces in WWII :contentReference[oaicite:35]{index=35}.</p>

  <h6 class="fw-bold mt-4">ℹ️ General Information</h6>
  <ul>
    <li><strong>Location:</strong> Tecson & Fulgencio Streets, Brgy. San Vicente, San Miguel, Bulacan</li>
    <li><strong>Built:</strong> 1921</li>
    <li><strong>Style:</strong> Three‑story bahay na bato with stained glass, wrought‑iron grills, Art Nouveau details, Machuca tiles etc. :contentReference[oaicite:36]{index=36}</li>
    <li><strong>Usage:</strong> Ballroom, WWII Japanese HQ</li>
  </ul>

  <h6 class="fw-bold mt-4">🎯 FAQs</h6>
  <ol>
    <li><strong>Is interior accessible?</strong> No. It's closed due to structural hazards.</li>
    <li><strong>Importance?</strong> Unique three‑story colonial residence; social and wartime history.</li>
    <li><strong>Current condition?</strong> Badly deteriorated—missing floors, termite damage, unstable structure :contentReference[oaicite:37]{index=37}.</li>
  </ol>

  <h6 class="fw-bold mt-4">💡 Visiting Tips</h6>
  <ul>
    <li>Stick to the **exterior**—unsafe to enter.</li>
    <li>Visit in the morning for the best lighting.</li>
    <li>Combine with heritage sites in the area for a richer tour.</li>
    <li>Local restoration efforts need support—heritage‑advocates welcome.</li>
  </ul>

  <p class="mt-3 text-muted"><em>A grand colonial memory at risk—but still telling stories of status, culture, and history.</em></p>
`,
      'First Scout Ranger Regiment: Camp Tecson': `
    <h6 class="fw-bold">🪖 Description & Military Role</h6>
    <p><strong>Camp Tecson</strong> (also known as <em>Camp Pablo Tecson</em>) is the headquarters of the Philippine Army’s elite <strong>First Scout Ranger Regiment (FSRR)</strong>. Founded in 1950 and modeled after the U.S. Army Rangers and Alamo Scouts, the unit is trained in jungle warfare, urban combat, raids, reconnaissance, and counter-insurgency operations.</p>

    <h6 class="fw-bold mt-4">ℹ️ General Info & Facilities</h6>
    <ul>
        <li><strong>Location:</strong> Camp Pablo Tecson, San Miguel, Bulacan</li>
        <li><strong>Founded:</strong> November 25, 1950</li>
        <li><strong>Notable Unit:</strong> 21st Scout Ranger Company (activated 2019)</li>
        <li><strong>Training Zones:</strong> Includes “Bayani City” – a military urban training facility completed in 2023–2025</li>
    </ul>

    <h6 class="fw-bold mt-4">🏗️ Key Infrastructure</h6>
    <ul>
        <li><strong>Scout Ranger Orientation Course (SROC):</strong> 45-day elite training for recruits</li>
        <li><strong>Bayani City:</strong> Military Operations on Urban Terrain (MOUT) site with buildings, tunnels, and roads</li>
        <li><strong>Recent Upgrades:</strong> New barracks and swimming pool for advanced tactical training</li>
    </ul>

    <h6 class="fw-bold mt-4">🎯 FAQs</h6>
    <ol>
        <li><strong>Can civilians enter Camp Tecson?</strong> No. It’s a secured military facility and not open to the public.</li>
        <li><strong>What makes it special?</strong> It is home to the Scout Rangers, the Philippines’ top special operations force.</li>
        <li><strong>What events happen there?</strong> Military anniversaries, national-level patrol competitions (e.g., Katihan Patrol), and training graduations.</li>
        <li><strong>Is it historically important?</strong> Yes, the base was established in the post-WWII era and continues to shape military operations today.</li>
    </ol>

    <h6 class="fw-bold mt-4">💡 Tips for Locals & Researchers</h6>
    <ul>
        <li>While you can’t enter the base, historical markers and perimeter areas may be visible from public roads.</li>
        <li>Contact the local government or AFP Public Affairs if requesting special access or filming.</li>
        <li>Great for history enthusiasts exploring military heritage in Bulacan.</li>
    </ul>

    <p class="mt-3 text-muted"><em>Camp Tecson stands as a pillar of national defense, elite training, and military heritage in San Miguel, Bulacan.</em></p>
`,
      'Sibul Spring Resort': `
  <h6 class="fw-bold">🏞️ Description & Features</h6>
  <p><strong>Sibul Spring Resort</strong>, also known simply as <em>Sibul Springs</em>, is a charming nature-based resort in Sitio Madlum, San Miguel, Bulacan. Known for its <strong>sulfur-rich hot springs</strong> and relaxing forest surroundings, it offers natural pools, shaded cottages, and rustic charm—ideal for day trips and nature therapy. It's part of the scenic Biak-na-Bato ecological zone.</p>

  <h6 class="fw-bold mt-4">ℹ️ General Information</h6>
  <ul>
    <li><strong>Location:</strong> Sitio Madlum, Brgy. Sibul, San Miguel, Bulacan</li>
    <li><strong>Natural Feature:</strong> Sulfuric hot springs, therapeutic water pools</li>
    <li><strong>Nearby:</strong> Madlum River, Biak-na-Bato National Park, Mount Manalmon</li>
    <li><strong>Ideal for:</strong> Families, hikers, nature lovers, and wellness seekers</li>
  </ul>

  <h6 class="fw-bold mt-4">🎯 FAQs</h6>
  <ol>
    <li><strong>Open to public?</strong> Yes, for day trips. No entrance fee, but pool and cottage rentals may apply.</li>
    <li><strong>Overnight stays?</strong> Mostly for daytime use; limited overnight options—ask locals in advance.</li>
    <li><strong>What to bring?</strong> Swimwear, towels, drinking water, cash, and insect repellent.</li>
    <li><strong>Is it safe?</strong> Yes, but best to avoid peak rainfall days when water levels rise.</li>
  </ol>

  <h6 class="fw-bold mt-4">💡 Visiting Tips</h6>
  <ul>
    <li>Arrive early to avoid crowds and secure a good spot.</li>
    <li>Combine with a trek to Mount Manalmon or Madlum Cave.</li>
    <li>Help maintain cleanliness—dispose of trash properly.</li>
    <li>Support local vendors by buying snacks or renting cottages.</li>
  </ul>

  <p class="mt-3 text-muted"><em>Sibul Spring offers a rare mix of healing waters, mountain views, and peaceful ambiance—making it a refreshing escape close to home.</em></p>
`,
      'Malapad na Parang': `
  <h6 class="fw-bold">🏞️ Description & Setting</h6>
  <p><strong>Malapad na Parang</strong> is a wide plain in Sitio Malapad na Parang, Sibul, San Miguel. It's known for its flat agricultural terrain and scenic views, including the prayerful vantage of the Our Lady of Grace grotto high above the plain.</p>

  <h6 class="fw-bold mt-4">ℹ️ General Info</h6>
  <ul>
    <li><strong>Location:</strong> Sitio Malapad na Parang, Brgy. Sibul</li>
    <li><strong>Terrain:</strong> Loam/clay plain within Biak‑na‑Bato National Park</li>
    <li><strong>Landmark:</strong> Our Lady of Grace grotto with Stations of the Cross</li>
  </ul>

  <h6 class="fw-bold mt-4">🎯 FAQs</h6>
  <ol>
    <li><strong>What is Malapad na Parang?</strong> A wide, agricultural plain in Sibul.</li>
    <li><strong>Why the name?</strong> "Malapad" means wides and it reflects the flat land.</li>
    <li><strong>Can I visit the grotto?</strong> Yes, it's publicly accessible for prayer and reflection.</li>
    <li><strong>Is it inside a national park?</strong> Yes, it's part of Biak‑na‑Bato’s ecosystem.</li>
    <li><strong>How to get there?</strong> Drive via Kamias‑Sibul Rd, cross Brown Bridge, follow signs for grotto.</li>
  </ol>

  <h6 class="fw-bold mt-4">💡 Tips</h6>
  <ul>
    <li>Visit early/late in the day for cooler temps and good lighting</li>
    <li>Bring modest attire if visiting grotto</li>
    <li>Keep the area clean and respectful</li>
    <li>Combine with hikes to Sibul Springs or Biak-na-Bato caves</li>
  </ul>

  <p class="mt-3 text-muted"><em>A serene mix of nature and faith—a reflective scenic spot in San Miguel.</em></p>
`,
      'Mount Manalmon': `
  <h6 class="fw-bold">🗻 Description & Highlights</h6>
  <p>Mount Manalmon (~160 m), in Sitio Madlum, San Miguel, Bulacan, is a scenic beginner-friendly peak in Biak‑na‑Bato National Park. Expect river crossings, caves, rocky summit scrambles, and sweeping 360° views including Sierra Madre, Mt. Arayat, and Mt. Gola.</p>

  <h6 class="fw-bold mt-4">ℹ️ General Info</h6>
  <ul>
    <li><strong>Elevation:</strong> 160–196 m (2/9 difficulty)</li>
    <li><strong>Trail:</strong> Forest paths, Madlum Cave, rock scrambles</li>
    <li><strong>Typical Hike Time:</strong> 1–2 hours loop (~3.7 km)</li>
    <li><strong>Fees:</strong> Php 15–20 registration, Php 300 guide</li>
  </ul>

  <h6 class="fw-bold mt-4">🎯 FAQs</h6>
  <ol>
    <li><strong>Guide needed?</strong> Yes—mandatory, Php 300 day‑hike</li>
    <li><strong>Best season?</strong> Dry months (Dec–May), start early</li>
    <li><strong>Nearby sights?</strong> Mt. Gola, Madlum & Bayukbok caves, monkey bridge, river swim</li>
  </ol>

  <h6 class="fw-bold mt-4">💡 Tips</h6>
  <ul>
    <li>Arrive before sunrise</li>
    <li>Bring 1–2 L water, snacks, and sturdy shoes</li>
    <li>Use a waterproof case for devices</li>
  </ul>

  <p class="mt-3 text-muted"><em>A short yet rewarding day‑hike full of nature, adventure, and stunning views.</em></p>
`,
      'Madlum Cave (Manalmon Cave)': `
  <h6 class="fw-bold">🕳️ Description & Highlights</h6>
  <p>Madlum Cave is a short limestone tunnel along Madlum River, part of the Mt. Manalmon loop in Biak‑na‑Bato National Park. Hikers pass through a hanging bridge and the cave before ascending to the summit.</p>

  <h6 class="fw-bold mt-4">ℹ️ General Info</h6>
  <ul>
    <li><strong>Location:</strong> Sitio Madlum, Brgy. Sibul, San Miguel, Bulacan (inside Biak‑na‑Bato NP)</li>
    <li><strong>Trail:</strong> Easy, beginner-friendly cave on way to Mt. Manalmon</li>
    <li><strong>Guide & Fees:</strong> Guide (₱150–300), registration (₱15–20)</li>
    <li><strong>Safety:</strong> Short tunnel, low ceiling, slippery floors—wear good footwear and bring headlamp</li>
  </ul>

  <h6 class="fw-bold mt-4">🎯 FAQs</h6>
  <ol>
    <li><strong>Length?</strong> About 100 steps; takes ~5–10 min.</li>
    <li><strong>Permit & guide?</strong> Yes—required for safety and access.</li>
    <li><strong>Safe for beginners?</strong> Yes, but watch your footing.</li>
    <li><strong>Best time?</strong> Dry season, early morning.</li>
    <li><strong>Solo visit?</strong> No—group guides ensure safety.</li>
  </ol>

  <h6 class="fw-bold mt-4">💡 Tips</h6>
  <ul>
    <li>Bring headlamp and wear anti-slip shoes</li>
    <li>Avoid wet days; cave may flood</li>
    <li>Combine with Mt. Manalmon, Bayukbok Cave, river swim, and monkey bridge</li>
    <li>Bring extra clothes and towel</li>
    <li>Secure guide and permit in advance</li>
  </ul>

  <p class="mt-3 text-muted"><em>A brief yet memorable spelunking stop in a scenic eco-adventure circuit.</em></p>
`,
      'Bayukbok Cave': `
  <h6 class="fw-bold">🕳️ Description & Highlights</h6>
  <p>Bayukbok Cave is an adventurous spelunking destination in Sitio Madlum. It consists of interconnected chambers—typically six explored—with rappels, tunnels, bamboo ladders, and dramatic stalactites. It’s also historically significant, believed to have sheltered Katipuneros during the revolution.</p>

  <h6 class="fw-bold mt-4">ℹ️ General Info</h6>
  <ul>
    <li><strong>Location:</strong> Sitio Madlum, Brgy. Sibul, San Miguel, Bulacan (Biak-na-Bato NP)</li>
    <li><strong>Chambers:</strong> 6–8 interconnected caves, first 6 accessible to tourists</li>
    <li><strong>Difficulty:</strong> 7–8/10 – includes rappels (14 ft), rope ladders, tight crawls</li>
  </ul>

  <h6 class="fw-bold mt-4">🎯 FAQs</h6>
  <ol>
    <li><strong>Duration?</strong> 2–3 hours to complete caving plus nearby hikes.</li>
    <li><strong>Permit & guide?</strong> Yes—₱15–20 permit, guide ₱150–300; group ratio rules apply.</li>
    <li><strong>Suitable for?</strong> Fit and adventurous people—narrow, slippery, technical.</li>
    <li><strong>Unique features?</strong> Music Room, stalactites/stalagmites, rope ladders, vine swings.</li>
    <li><strong>Best time?</strong> Dry season (Dec–May), avoid after heavy rain.</li>
  </ol>

  <h6 class="fw-bold mt-4">💡 Tips</h6>
  <ul>
    <li>Wear grip shoes, bring headlamp, gloves, towel.</li>
    <li>Move slowly, follow guide, mind safety—avoid wet days.</li>
    <li>Reserve permit ahead via barangay tourism.</li>
    <li>Pair with Mt. Manalmon, Mt. Gola, Madlum Cave traverse, and Monkey Bridge.</li>
  </ul>

  <p class="mt-3 text-muted"><em>An exhilarating underground journey through nature’s chambers—tough, thrilling, unforgettable.</em></p>
`,
      'Madlum Falls': `
  <h6 class="fw-bold">🏞️ Description & Setting</h6>
  <p><strong>Madlum Falls</strong> is a scenic waterfall and plunge pool set amidst limestone boulders and verdant forest in Sitio Madlum, San Miguel. It's part of the ecological trio of waterfalls, caves, and limestone peaks around the Madlum River.</p>

  <h6 class="fw-bold mt-4">ℹ️ General Information</h6>
  <ul>
    <li><strong>Location:</strong> Sitio Madlum, Brgy. Sibul, San Miguel (Biak‑na‑Bato NP)</li>
    <li><strong>Feature:</strong> Natural freshwater falls with swimming pool</li>
    <li><strong>Surroundings:</strong> Limestone walls, forest canopy, part of river‑cave‑mountain circuit</li>
  </ul>

  <h6 class="fw-bold mt-4">🎯 FAQs</h6>
  <ol>
    <li><strong>How get there?</strong> Same guided trail to Mt. Manalmon; registration (₱15–20), guide (₱300/day).</li>
    <li><strong>Swim safe?</strong> Yes in dry season; avoid after rains.</li>
    <li><strong>Entrance fees?</strong> Only regular trail registration—no extra fall fee.</li>
    <li><strong>Best season?</strong> December–May, early morning visits suggested.</li>
    <li><strong>Kid‑friendly?</strong> With proper adult supervision and buoyancy support.</li>
  </ol>

  <h6 class="fw-bold mt-4">💡 Visiting Tips</h6>
  <ul>
    <li>Wear grip‑sole shoes for slippery rocks</li>
    <li>Bring float or life vest for swimming</li>
    <li>Keep it clean—no soaps, pack out all trash</li>
    <li>Divide your hike—Madlum Falls fits well with cave and summit loop</li>
  </ul>

  <p class="mt-3 text-muted"><em>A refreshing waterfall stop within a rich nature‑adventure circuit—perfect for a dip after a cave or mountain hike.</em></p>
`,
      'Madlum River': `
  <h6 class="fw-bold">🏞️ Description & Appeal</h6>
  <p>Madlum River winds through marble-cliff gorges in Sitio Madlum, offering cool clear pools for swimming, bamboo raft rides, and rope-bridge crossings. It's a scenic entry point to the Mt. Manalmon hiking circuit.</p>

  <h6 class="fw-bold mt-4">ℹ️ General Info</h6>
  <ul>
    <li><strong>Location:</strong> Sitio Madlum, Brgy. Sibul (inside Biak‑na‑Bato NP)</li>
    <li><strong>Features:</strong> Marble rockbed, swimming pools, forest backdrop</li>
    <li><strong>Attractions:</strong> Bamboo raft crossings, monkey rope bridge</li>
  </ul>

  <h6 class="fw-bold mt-4">🎯 FAQs</h6>
  <ol>
    <li><strong>Swimming?</strong> Yes—refreshing pools are ideal after hikes.</li>
    <li><strong>Safety?</strong> Generally safe in dry season; avoid flash floods.</li>
    <li><strong>Fees/permits?</strong> No river fee—trail permit (₱15–20) and guide (~₱300) needed nearby.</li>
    <li><strong>Best time?</strong> December–May on weekdays.</li>
    <li><strong>How to reach?</strong> Bus to San Miguel, then tricycle to Sitio Madlum, registration.</li>
  </ol>

  <h6 class="fw-bold mt-4">💡 Tips</h6>
  <ul>
    <li>Wear non-slip water shoes</li>
    <li>Experience the rustic monkey bridge</li>
    <li>Pack swim gear and essentials</li>
    <li>Visit early for calm waters</li>
    <li>Check weather before heading out</li>
  </ul>

  <p class="mt-3 text-muted"><em>A refreshing river oasis nestled in limestone gorges—perfect for a dip or photo stop on an eco-adventure.</em></p>
`,
      'Mount Gola': `
  <h6 class="fw-bold">🗻 Description & Highlights</h6>
  <p>Mount Gola (~160–196 m) is a rocky, beginner‑friendly peak beside Mt. Manalmon in Biak‑na‑Bato NP. The climb features river crossings, a monkey bridge, a short cave passage, and a rewarding summit panorama of Sierra Madre and Mt. Arayat.</p>

  <h6 class="fw-bold mt-4">ℹ️ General Info</h6>
  <ul>
    <li><strong>Location:</strong> Sitio Madlum, Brgy. Sibul (Biak‑na‑Bato NP)</li>
    <li><strong>Elevation:</strong> ~160–196 m, difficulty 2/9</li>
    <li><strong>Trail Features:</strong> Stations of the Cross, cave, river crossing, rocky summit</li>
    <li><strong>Summit View:</strong> Sierra Madre, Mt. Arayat, Mt. Manalmon</li>
  </ul>

  <h6 class="fw-bold mt-4">🎯 FAQs</h6>
  <ol>
    <li><strong>Permit & guide:</strong> Required (~₱15–20 + ₱300)</li>
    <li><strong>Duration:</strong> ~1–1.5 hrs to summit; 4–6 hrs for full loop</li>
    <li><strong>Difficulty:</strong> Moderate—easy with some rock scrambling</li>
    <li><strong>Best season:</strong> Dry months (Dec–May), early start recommended</li>
  </ol>

  <h6 class="fw-bold mt-4">💡 Tips</h6>
  <ul>
    <li>Wear grip‑sole shoes, bring hydration & sunblock</li>
    <li>Combine twin peaks & cave loop for full adventure</li>
    <li>Go on weekdays for fewer crowds</li>
    <li>Camping is allowed—great for stargazing</li>
  </ul>

  <p class="mt-3 text-muted"><em>An accessible yet thrilling peak with panoramic views and nature‑filled experiences—ideal for both day-hike and overnight camping.</em></p>
`,
      'The Cabin Resorts': `
  <h6 class="fw-bold">🏡 Description & Ambience</h6>
  <p><strong>The Cabin Resorts</strong> is a cozy farm resort in San Miguel, Bulacan—built in 2017 inside rice fields, offering A‑frame cabins, a serene lake, and sustainable design.</p>

  <h6 class="fw-bold mt-4">ℹ️ Accommodation & Amenities</h6>
  <ul>
    <li><strong>Deluxe Cabin (₱7,500/night):</strong> 2–3 guests; AC, Wi‑Fi, TV, minibar, workspace, veranda.</li>
    <li><strong>Loft Cabin (₱12,500/night):</strong> 6–8 guests; loft bedroom, kitchen, spacious living area.</li>
    <li>Solar-powered, eco-conscious, designed for privacy and nature immersion.</li>
  </ul>

  <h6 class="fw-bold mt-4">🎯 Facilities & Activities</h6>
  <ul>
    <li>Free: pool, kayak, bike, badminton, archery, fishing, lake infinity pool</li>
    <li>Paid: ATV, bonfire, romantic dinners, picnic packages</li>
    <li>Restobar serves Filipino comfort food and all-day breakfast.</li>
  </ul>

  <h6 class="fw-bold mt-4">🎯 FAQs</h6>
  <ol>
    <li><strong>Pet & kid-friendly?</strong> Yes—small pets ok (₱1,500 fee).</li>
    <li><strong>Extra guests?</strong> ₱1,500/head; breakfast + amenities included.</li>
    <li><strong>How to get there?</strong> Best by private vehicle; resort offers pickup from Gulf Gas Station.</li>
    <li><strong>Bring:</strong> Swimwear, toiletries in reusable containers, sunscreen, bug spray.</li>
    <li><strong>COVID safety?</strong> Health check, fog sanitation, spaced activities enforced.</li>
  </ol>

  <h6 class="fw-bold mt-4">💡 Tips</h6>
  <ul>
    <li>Book weekdays to avoid crowds.</li>
    <li>Photo ops: wooden pier, infinity sunset pool, rice field views.</li>
    <li>Unplug—Wi‑Fi in common zones only.</li>
  </ul>

  <p class="mt-3 text-muted"><em>A rustic-luxe escape blending farm life, eco-conscious design, and immersive nature connectivity—ideal for families, couples, or barkada stays.</em></p>
`,
      'Kamote Resort': `
  <h6 class="fw-bold">🏞️ Description & Highlights</h6>
  <p><strong>Kamote Resort</strong> is a peaceful riverside haven in Sitio Sibul, San Miguel. Nestled between limestone cliffs and forest, it features clear river pools, bamboo rafts, floating cottages, and rafting activities.</p>
  
  <h6 class="fw-bold mt-4">ℹ️ General Information</h6>
  <ul>
    <li><strong>Location:</strong> Sibul–Biak‑na‑Bato Rd, Brgy. Sibul, San Miguel</li>
    <li><strong>Features:</strong> River pools, rafting, bamboo/floating cottages</li>
    <li><strong>Visitor Rating:</strong> ~3.6–3.8/5 from local reviews</li>
  </ul>

  <h6 class="fw-bold mt-4">🎯 FAQs</h6>
  <ol>
    <li><strong>Open to public?</strong> Yes—day-trip friendly, no entrance fee.</li>
    <li><strong>Activities?</strong> Rafting, swimming, floating cottages, bamboo platforms.</li>
    <li><strong>Lodging?</strong> Simple cottages; no overnight stays typical.</li>
    <li><strong>How to get there?</strong> Bus to San Miguel, then tricycle or private vehicle; use Waze.</li>
    <li><strong>Rating?</strong> Modest (3.6/5), offering a natural, rustic experience.</li>
  </ol>

  <h6 class="fw-bold mt-4">💡 Visitor Tips</h6>
  <ul>
    <li>Arrive early to avoid crowds.</li>
    <li>Bring swim and comfort gear (towels, water shoes).</li>
    <li>Carry cash for rentals, snacks, and cottage use.</li>
    <li>Combine with nearby spots like Mt. Manalmon or Sibul Springs.</li>
    <li>Keep the area clean—no trash left behind.</li>
  </ul>

  <p class="mt-3 text-muted"><em>A charming rustic resort by the river—great for a relaxed escape and fun water activities in San Miguel.</em></p>
`,
      'Banal na Bundok': `
  <h6 class="fw-bold">🏞️ Description & Significance</h6>
  <p><strong>Banal na Bundok</strong> (Holy Mountain) in Sitio Balingkupang, San Miguel, is a pilgrimage hill featuring a 25‑ft Holy Cross, life-size Stations of the Cross, chapel, Seven Archangels statuary, and a scenic hill climb with deep spiritual significance.</p>

  <h6 class="fw-bold mt-4">ℹ️ General Info</h6>
  <ul>
    <li><strong>Location:</strong> Sitio Balingkupang, Brgy. Biak‑na‑Bato</li>
    <li><strong>Trail:</strong> Over 45 concrete steps, easy-moderate climb</li>
    <li><strong>Religious Features:</strong> Holy Cross, Stations of the Cross, chapel, angel gallery, Marian grottoes, natural “face of Christ” rock</li>
  </ul>

  <h6 class="fw-bold mt-4">🎯 FAQs</h6>
  <ol>
    <li><strong>What is it?</strong> Faith hill with shrines and devotional stops.</li>
    <li><strong>Why the name?</strong> Referencing Christ’s shape and spiritual symbolism.</li>
    <li><strong>Climb level?</strong> Moderate—45+ stairs to the summit.</li>
    <li><strong>Safe to visit?</strong> Yes—well-maintained paths, chapel available.</li>
    <li><strong>Best time?</strong> Any—but peak during Holy Week.</li>
    <li><strong>Miracles?</strong> Eagle sightings, healing faith stories since 1999.</li>
  </ol>

  <h6 class="fw-bold mt-4">💡 Tips</h6>
  <ul>
    <li>Climb early or on weekdays for serenity</li>
    <li>Bring prayers, candles, rosary for devotion</li>
    <li>Wear grip shoes—steps can be steep</li>
    <li>Capture sunrise and summit photos</li>
    <li>Enjoy picnic spots at the base</li>
  </ul>

  <p class="mt-3 text-muted"><em>A serene pilgrimage hill with panoramic views, spiritual depth, and cultural significance—especially poignant during Holy Week.</em></p>
`,
      'Biak-na-Bato National Park': `
  <h6 class="fw-bold">🏞️ Description & Significance</h6>
  <p>Biak‑na‑Bato National Park (2,117 ha) is a historic and ecological gem—site of the Republic of Biak‑na‑Bato (1897) and home to karst gorges, caves, rivers, peaks, and endemic wildlife.</p>
  <h6 class="fw-bold mt-4">🌿 Topography & Ecology</h6>
  <ul>
    <li>Limestone gorges, rivers (Balaong, Madlum), 100+ caves</li>
    <li>Rich flora: orchids, narra, molave, ferns, vines</li>
    <li>Wildlife: bats, hornbills, macaques, deer, cloud rats, monitor lizards, endemic frog <em>P. biak</em></li>
  </ul>
  <h6 class="fw-bold mt-4">🏛️ History & Adventure</h6>
  <ul>
    <li>Aguinaldo, Tanggapan, Bat Cave: revolutionary hideouts</li>
    <li>Trails with hanging bridges, cave spelunking, swimming pools</li>
    <li>Key sites: Mt. Manalmon, Mt. Gola, Madlum River, Tilandong Falls</li>
  </ul>
  <h6 class="fw-bold mt-4">🎯 FAQs</h6>
  <ol>
    <li><strong>Getting there?</strong> 2 hrs by car (via NLEX → Sta. Rita), or bus + trike.</li>
    <li><strong>Fees?</strong> ₱20–50 entry; guides ₱150–300/group; cave/headlamp ₱150–180.</li>
    <li><strong>Safe?</strong> Yes, but avoid rainy season—flood risk.</li>
    <li><strong>Best season?</strong> Nov–May, weekdays recommended.</li>
    <li><strong>Activities?</strong> Hiking, caving, swimming, bird‑watching, camping.</li>
  </ol>
  <h6 class="fw-bold mt-4">💡 Tips</h6>
  <ul>
    <li>Wear covered footwear, bring water and sun protection</li>
    <li>Book guides and permit onsite at DENR station</li>
    <li>Bring waterproof phone protection and insect repellent</li>
    <li>Preserve cleanliness—carry out trash</li>
    <li>Start early to beat crowds and heat</li>
  </ul>
  <p class="mt-3 text-muted"><em>A living blend of Philippine history and wilderness, Biak‑na‑Bato offers culture, adventure, and natural beauty just two hours from Manila.</em></p>
`,
      'Bahay Paniki Cave': `
    <h6 class="fw-bold">🦇 Description & Significance</h6>
    <p>Named for its thriving bat population, Bahay Paniki Cave is a popular spelunking destination inside Biak-na-Bato. The cave offers a glimpse into rich biodiversity and geologic formations.</p>

    <h6 class="fw-bold mt-4">🗺️ General Info</h6>
    <ul>
      <li><strong>Location:</strong> Biak-na-Bato National Park</li>
      <li><strong>Features:</strong> Large chambers, bat colonies, stalactites</li>
      <li><strong>Popular For:</strong> Guided spelunking and wildlife watching</li>
    </ul>

    <h6 class="fw-bold mt-4">🎯 FAQs</h6>
    <ol>
      <li><strong>Do I need a guide?</strong> Yes, required for safety and orientation.</li>
      <li><strong>How long is the tour?</strong> Around 30–45 minutes.</li>
      <li><strong>Can I take photos?</strong> Yes, but flash may disturb bats.</li>
    </ol>

    <h6 class="fw-bold mt-4">💡 Tips</h6>
    <ul>
      <li>Wear headlamps and gloves for grip</li>
      <li>Respect wildlife—avoid loud noises</li>
      <li>Be ready for uneven terrain and guano</li>
    </ul>

    <p class="mt-3 text-muted"><em>A must-visit for spelunking fans and wildlife enthusiasts exploring Biak-na-Bato.</em></p>
  `,
      'Aguinaldo Cave': `
    <h6 class="fw-bold">📜 Description & Significance</h6>
    <p>Aguinaldo Cave served as a secret headquarters of Gen. Emilio Aguinaldo and his revolutionary forces. It’s a living piece of Philippine history within the wilderness of Biak-na-Bato.</p>

    <h6 class="fw-bold mt-4">📍 General Info</h6>
    <ul>
      <li><strong>Location:</strong> Biak-na-Bato National Park</li>
      <li><strong>Historical Role:</strong> Shelter and war room during the 1897 revolution</li>
      <li><strong>Features:</strong> Narrow passages, natural rock formations</li>
    </ul>

    <h6 class="fw-bold mt-4">🎯 FAQs</h6>
    <ol>
      <li><strong>Is it hard to reach?</strong> Requires short hike with a guide</li>
      <li><strong>Can I go inside?</strong> Yes, guided entry only</li>
      <li><strong>Photography allowed?</strong> Yes, no flash inside</li>
    </ol>

    <h6 class="fw-bold mt-4">💡 Tips</h6>
    <ul>
      <li>Bring a flashlight and be mindful of slippery rocks</li>
      <li>Ask guides for historical insights—they share great stories</li>
      <li>Combine with visit to other nearby caves</li>
    </ul>

    <p class="mt-3 text-muted"><em>A powerful destination for heritage travelers and history buffs alike.</em></p>
  `,
      'Cuarto-Cuarto Cave': `
    <h6 class="fw-bold">🕳️ Description & Significance</h6>
    <p>Cuarto-Cuarto Cave, known for its "chamber-to-chamber" structure, is an exciting spelunking destination inside Biak-na-Bato. The cave name means "room-to-room"—a nod to its multi-section layout.</p>

    <h6 class="fw-bold mt-4">📍 General Info</h6>
    <ul>
      <li><strong>Location:</strong> Inside Biak-na-Bato National Park</li>
      <li><strong>Highlights:</strong> Narrow hallways, climbing spots, rock formations</li>
      <li><strong>Best For:</strong> Adventure seekers and experienced spelunkers</li>
    </ul>

    <h6 class="fw-bold mt-4">🎯 FAQs</h6>
    <ol>
      <li><strong>Time required?</strong> About 45–60 minutes</li>
      <li><strong>Is it dark?</strong> Yes, headlamp recommended</li>
      <li><strong>Need a guide?</strong> Yes, for safety and navigation</li>
    </ol>

    <h6 class="fw-bold mt-4">💡 Tips</h6>
    <ul>
      <li>Best explored during dry season</li>
      <li>Wear flexible, non-slip footwear</li>
      <li>Check for bats and insects inside chambers</li>
    </ul>

    <p class="mt-3 text-muted"><em>Cuarto-Cuarto Cave lives up to its name—each chamber offers new excitement and wonder.</em></p>
  `,
      'Tilandong Falls': `
    <h6 class="fw-bold">💦 Description & Significance</h6>
    <p>Tilandong Falls is a hidden gem inside Biak-na-Bato National Park, offering cool cascading waters in a serene forest setting. Ideal for nature lovers seeking a refreshing dip after a hike.</p>

    <h6 class="fw-bold mt-4">📍 General Info</h6>
    <ul>
      <li><strong>Location:</strong> Biak-na-Bato National Park</li>
      <li><strong>Activities:</strong> Hiking, swimming, nature photography, picnicking</li>
      <li><strong>Trail:</strong> Moderate trail, around 30 minutes hike</li>
    </ul>

    <h6 class="fw-bold mt-4">🎯 FAQs</h6>
    <ol>
      <li><strong>Can we swim?</strong> Yes, shallow and safe waters</li>
      <li><strong>Open year-round?</strong> Yes, but best during dry season</li>
      <li><strong>Are there cottages?</strong> No, bring mats or tents</li>
    </ol>

    <h6 class="fw-bold mt-4">💡 Tips</h6>
    <ul>
      <li>Bring waterproof bags for electronics</li>
      <li>Wear aqua shoes or hiking sandals</li>
      <li>Start early to avoid the heat</li>
    </ul>

    <p class="mt-3 text-muted"><em>Tilandong Falls is a perfect combo of light adventure and peaceful escape within the park.</em></p>
  `,
      'Tanggapan Cave': `
    <h6 class="fw-bold">🛡️ Description & Significance</h6>
    <p>Tanggapan Cave served as a lookout and defense point for revolutionaries during the Spanish era. Its concealed location and narrow passages made it an ideal hideout in wartime.</p>

    <h6 class="fw-bold mt-4">📍 General Info</h6>
    <ul>
      <li><strong>Location:</strong> Biak-na-Bato National Park</li>
      <li><strong>Features:</strong> Tight spaces, defensive position, historical relevance</li>
      <li><strong>Best For:</strong> History lovers and hikers</li>
    </ul>

    <h6 class="fw-bold mt-4">🎯 FAQs</h6>
    <ol>
      <li><strong>Still accessible?</strong> Yes, via guided trek</li>
      <li><strong>Is spelunking allowed?</strong> Yes, light spelunking with guide</li>
      <li><strong>What makes it unique?</strong> Historical use as a revolutionary cave</li>
    </ol>

    <h6 class="fw-bold mt-4">💡 Tips</h6>
    <ul>
      <li>Bring flashlights for dark corners</li>
      <li>Listen to guides' stories about its wartime use</li>
      <li>Pair visit with Aguinaldo and Imbakan Cave</li>
    </ul>

    <p class="mt-3 text-muted"><em>Tanggapan Cave is not just a natural site—it’s a silent witness to Filipino resilience.</em></p>
  `,

      'Hospital Cave': `
    <h6 class="fw-bold">🏥 Description & Significance</h6>
    <p>As the name implies, Hospital Cave was reportedly used to treat wounded revolutionaries. Its relative seclusion and wide chamber made it a functional wartime infirmary.</p>

    <h6 class="fw-bold mt-4">📍 General Info</h6>
    <ul>
      <li><strong>Location:</strong> Inside Biak-na-Bato National Park</li>
      <li><strong>Historical Use:</strong> Shelter and treatment center during revolution</li>
      <li><strong>Access:</strong> By trail with local guide</li>
    </ul>

    <h6 class="fw-bold mt-4">🎯 FAQs</h6>
    <ol>
      <li><strong>Is it a large cave?</strong> Moderate size, wide chamber</li>
      <li><strong>Is spelunking allowed?</strong> Yes, with basic gear</li>
      <li><strong>Is there any signage?</strong> Yes, DENR-labeled site</li>
    </ol>

    <h6 class="fw-bold mt-4">💡 Tips</h6>
    <ul>
      <li>Good site to combine with nearby caves</li>
      <li>Respect historical context—take only photos</li>
      <li>Look for graffiti or markings from the era</li>
    </ul>

    <p class="mt-3 text-muted"><em>Hospital Cave reflects the hardships and ingenuity of Filipino heroes in hiding.</em></p>
  `,

      'Imbakan Cave': `
    <h6 class="fw-bold">📦 Description & Significance</h6>
    <p>Imbakan Cave served as a secret storage area (imbakan) for supplies during the revolution. It is quiet, dark, and naturally cool, perfect for hiding food and ammunition.</p>

    <h6 class="fw-bold mt-4">📍 General Info</h6>
    <ul>
      <li><strong>Location:</strong> Biak-na-Bato National Park</li>
      <li><strong>Main Use:</strong> Storage of supplies in 1897</li>
      <li><strong>Highlights:</strong> Cool interior, side pockets, hidden chambers</li>
    </ul>

    <h6 class="fw-bold mt-4">🎯 FAQs</h6>
    <ol>
      <li><strong>Easy to find?</strong> Not marked—ask your guide</li>
      <li><strong>Safe to enter?</strong> Yes, with basic precautions</li>
      <li><strong>Photography allowed?</strong> Yes, but lighting is limited</li>
    </ol>

    <h6 class="fw-bold mt-4">💡 Tips</h6>
    <ul>
      <li>Ask your guide about storage techniques used then</li>
      <li>Bring handheld flashlight</li>
      <li>Be mindful of slippery ground</li>
    </ul>

    <p class="mt-3 text-muted"><em>A quiet but crucial part of the revolutionary supply chain, Imbakan Cave holds stories untold.</em></p>
  `,
      'Ambush Cave': `
    <h6 class="fw-bold">⚔️ Description & Significance</h6>
    <p>Ambush Cave earned its name from its strategic use by revolutionaries in planning surprise attacks against Spanish forces. Its location allowed for concealment and tactical advantage.</p>

    <h6 class="fw-bold mt-4">📍 General Info</h6>
    <ul>
      <li><strong>Location:</strong> Inside Biak-na-Bato National Park</li>
      <li><strong>Use:</strong> Historical ambush site during the revolution</li>
      <li><strong>Terrain:</strong> Uneven rocky floor, bush-covered entrance</li>
    </ul>

    <h6 class="fw-bold mt-4">🎯 FAQs</h6>
    <ol>
      <li><strong>Is it open to tourists?</strong> Yes, with local guides</li>
      <li><strong>Can you explore inside?</strong> Yes, but with caution and headlamp</li>
      <li><strong>Marked on maps?</strong> Not always—ask DENR or locals</li>
    </ol>

    <h6 class="fw-bold mt-4">💡 Tips</h6>
    <ul>
      <li>Bring proper shoes for rocky terrain</li>
      <li>Ask guides to point out ambush positions</li>
      <li>Don’t stray far—wildlife and plants may obstruct paths</li>
    </ul>

    <p class="mt-3 text-muted"><em>Ambush Cave is a powerful reminder of revolutionary bravery amidst natural camouflage.</em></p>
  `,

      'Pahingahan Cave': `
    <h6 class="fw-bold">🛏️ Description & Significance</h6>
    <p>Pahingahan Cave, from "pahinga" meaning "rest," served as a rest stop for Katipuneros and local guides during long treks through the mountain trails of Biak-na-Bato.</p>

    <h6 class="fw-bold mt-4">📍 General Info</h6>
    <ul>
      <li><strong>Location:</strong> Biak-na-Bato National Park</li>
      <li><strong>Feature:</strong> Shaded, flat area ideal for group resting</li>
      <li><strong>Atmosphere:</strong> Quiet, cool, protected from sun and rain</li>
    </ul>

    <h6 class="fw-bold mt-4">🎯 FAQs</h6>
    <ol>
      <li><strong>Is camping allowed?</strong> Day rest only, no overnight</li>
      <li><strong>Are there benches or structures?</strong> None—natural resting spot</li>
      <li><strong>Good for breaks?</strong> Yes, especially mid-hike</li>
    </ol>

    <h6 class="fw-bold mt-4">💡 Tips</h6>
    <ul>
      <li>Hydrate and snack here during long hikes</li>
      <li>Respect silence—great for meditation or reflection</li>
      <li>Leave no trash behind</li>
    </ul>

    <p class="mt-3 text-muted"><em>Pahingahan Cave is a humble but vital spot where heroes once paused to gather strength.</em></p>
  `,

      'Maningning Cave': `
    <h6 class="fw-bold">🌟 Description & Significance</h6>
    <p>Maningning Cave, meaning "radiant" or "luminous," is known for its beautiful mineral deposits that sparkle when hit by light. It offers both geological wonder and peaceful solitude.</p>

    <h6 class="fw-bold mt-4">📍 General Info</h6>
    <ul>
      <li><strong>Location:</strong> Biak-na-Bato National Park</li>
      <li><strong>Features:</strong> Crystal-like rock formations, quiet atmosphere</li>
      <li><strong>Best Time:</strong> Late morning for optimal natural lighting</li>
    </ul>

    <h6 class="fw-bold mt-4">🎯 FAQs</h6>
    <ol>
      <li><strong>Why is it called Maningning?</strong> Refers to its glittering cave walls</li>
      <li><strong>Is spelunking hard?</strong> Mild to moderate; manageable for beginners</li>
      <li><strong>Photo-friendly?</strong> Absolutely—bring flashlight for shimmer effect</li>
    </ol>

    <h6 class="fw-bold mt-4">💡 Tips</h6>
    <ul>
      <li>Use flashlight at angles to bring out sparkle</li>
      <li>Don’t touch formations—they're fragile</li>
      <li>Enter with a guide to avoid getting lost in side tunnels</li>
    </ul>

    <p class="mt-3 text-muted"><em>Maningning Cave lives up to its name—an enchanting spot that glimmers in the heart of Biak-na-Bato.</em></p>
  `,
      'Mount Mabio (Mount Silid)': `
    <h6 class="fw-bold">⛰️ Description & Significance</h6>
    <p>Mount Mabio, also referred to as Mount Silid, is one of the forested peaks within the Biak-na-Bato range. It is popular among hikers for its panoramic views and natural tranquility.</p>

    <h6 class="fw-bold mt-4">📍 General Info</h6>
    <ul>
      <li><strong>Location:</strong> Biak-na-Bato, San Miguel, Bulacan</li>
      <li><strong>Elevation:</strong> Moderate climb suitable for beginners</li>
      <li><strong>Trail Features:</strong> Forested trail, wildlife sightings, view decks</li>
    </ul>

    <h6 class="fw-bold mt-4">🎯 FAQs</h6>
    <ol>
      <li><strong>Is it safe?</strong> Yes, with guide; mild incline trail</li>
      <li><strong>Time to summit?</strong> 1–2 hours depending on pace</li>
      <li><strong>Do I need a permit?</strong> Yes, register at DENR checkpoint</li>
    </ol>

    <h6 class="fw-bold mt-4">💡 Tips</h6>
    <ul>
      <li>Wear proper hiking shoes</li>
      <li>Bring water and light snacks</li>
      <li>Go early for sunrise views</li>
    </ul>

    <p class="mt-3 text-muted"><em>Mount Mabio offers serenity and sweeping views for those craving nature and solitude.</em></p>
  `,

      'Balaong River': `
    <h6 class="fw-bold">🌊 Description & Significance</h6>
    <p>Balaong River flows through the heart of San Miguel and Biak-na-Bato, offering cool waters, scenic banks, and abundant fish—ideal for family outings and nature lovers.</p>

    <h6 class="fw-bold mt-4">📍 General Info</h6>
    <ul>
      <li><strong>Location:</strong> San Miguel, Bulacan (within Biak-na-Bato area)</li>
      <li><strong>Features:</strong> Rocky stream, shallow to deep pools, raftable sections</li>
      <li><strong>Popular Activities:</strong> Swimming, fishing, bamboo rafting, picnicking</li>
    </ul>

    <h6 class="fw-bold mt-4">🎯 FAQs</h6>
    <ol>
      <li><strong>Best season?</strong> Summer months (March to May)</li>
      <li><strong>Is it clean?</strong> Relatively clean; avoid visiting after heavy rains</li>
      <li><strong>Kid-friendly?</strong> Yes, with adult supervision</li>
    </ol>

    <h6 class="fw-bold mt-4">💡 Tips</h6>
    <ul>
      <li>Bring waterproof bags and dry clothes</li>
      <li>Watch your step on slippery rocks</li>
      <li>Choose less-crowded weekdays for peaceful experience</li>
    </ul>

    <p class="mt-3 text-muted"><em>Balaong River is a refreshing escape perfect for bonding with nature and family.</em></p>
  `
    };
    spotModal.addEventListener('show.bs.modal', function (event) {
      var card = event.relatedTarget;
      var title = card.getAttribute('data-title');
      var image = card.getAttribute('data-image');
      document.getElementById('spotModalLabel').textContent = title;
      document.getElementById('spotModalImg').src = image;
      document.getElementById('spotModalImg').alt = title;

      // If long HTML content exists in our object, use it
      const descContainer = document.getElementById('spotModalDesc');
      if (spotDescriptions[title]) {
        descContainer.innerHTML = spotDescriptions[title];
      } else {
        // fallback for basic text
        descContainer.textContent = card.getAttribute('data-description') || "No details available.";
      }
    });
  </script>


</body>

</html>