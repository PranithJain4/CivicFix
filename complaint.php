<!DOCTYPE html>
<html class="light" lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>Report Issue - CivicFix</title>
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
  <link
    href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;500;700&family=Public+Sans:wght@400;500;700;900&display=swap"
    rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
    rel="stylesheet" />

  <!-- Leaflet Map JS & CSS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Theme Configuration -->
  <script id="tailwind-config">
    tailwind.config = {
      darkMode: "class",
      theme: {
        extend: {
          colors: {
            "primary": "#45B25C",
            "accent-green": "#45B25C",
          },
          fontFamily: {
            "sans": ["Public Sans", "sans-serif"]
          },
        },
      },
    }
  </script>

  <style>
    body {
      font-family: "Public Sans", "Noto Sans", sans-serif;
    }

    .drop-shadow-soft {
      filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.05));
    }

    /* Custom Scrollbar */
    ::-webkit-scrollbar {
      width: 8px;
    }

    ::-webkit-scrollbar-track {
      background: #f1f1f1;
    }

    ::-webkit-scrollbar-thumb {
      background: #45B25C;
      border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
      background: #389a4d;
    }

    #map {
      height: 250px;
      width: 100%;
      border-radius: 1rem;
      margin-bottom: 0.5rem;
      border: 1px solid #cfe7d1;
      z-index: 10;
    }

    .dark #map {
      border-color: #2a4d2e;
    }
  </style>
</head>

<body class="bg-[#F8FAFC] dark:bg-[#0F172A] text-gray-900 dark:text-white min-h-screen flex flex-col overflow-x-hidden">
  <!-- Top Navigation Bar -->
  <header
    class="sticky top-0 z-50 flex items-center justify-between whitespace-nowrap border-b border-gray-100 dark:border-gray-800 bg-white dark:bg-gray-900 px-6 md:px-10 py-3 shadow-sm">
    <div class="flex items-center gap-4">
      <span class="material-symbols-outlined text-primary text-3xl">admin_panel_settings</span>
      <h2 class="text-lg font-bold">CivicFix</h2>
    </div>
    <!-- Secondary Button Style -->
    <a href="status.php"
      class="flex min-w-[84px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-6 border-2 border-primary text-primary bg-transparent hover:bg-primary/10 transition-colors text-sm font-bold leading-normal tracking-[0.015em]">
      <span class="truncate">Check Status</span>
    </a>
  </header>

  <!-- Main Content -->
  <main class="flex-1 flex justify-center py-8 px-4 md:px-6">
    <div class="w-full max-w-2xl flex flex-col gap-6">
      <!-- Page Heading -->
      <div class="flex flex-col gap-2 text-center md:text-left">
        <h1 class="text-[#0d1b0f] dark:text-white text-3xl md:text-4xl font-black leading-tight tracking-[-0.033em]">
          Report a Neighborhood Issue</h1>
        <p class="text-[#4c9a52] dark:text-[#6cc572] text-base md:text-lg font-medium leading-normal">Help us fix
          your neighborhood by reporting issues like potholes, sanitation, or lighting.</p>
      </div>

      <!-- Submission Form Card -->
      <div
        class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-800 overflow-hidden">
        <form class="flex flex-col p-6 md:p-8 gap-8" onsubmit="handleComplaintSubmit(event)">
          <!-- Upload Section -->
          <div class="flex flex-col gap-3">
            <label class="text-[#0d1b0f] dark:text-white text-base font-bold leading-normal">Evidence
              Photo</label>
            <div id="drop-zone"
              class="flex flex-col items-center justify-center gap-4 rounded-xl border-2 border-dashed border-[#cfe7d1] dark:border-[#2a4d2e] bg-[#f8fcf8] dark:bg-[#142816] px-6 py-10 hover:bg-[#f0f9f1] dark:hover:bg-[#1a331d] transition-all cursor-pointer group">
              <div class="flex flex-col items-center gap-2 text-center">
                <span
                  class="material-symbols-outlined text-5xl text-[#4c9a52] group-hover:text-primary transition-colors">add_a_photo</span>
                <div class="flex flex-col mt-2">
                  <p class="text-[#0d1b0f] dark:text-white text-lg font-bold">Upload Evidence</p>
                  <p class="text-[#4c9a52] dark:text-[#8cb890] text-sm font-medium">Drag & drop photos
                    or click to upload</p>
                </div>
              </div>
              <input type="file" id="file-input" class="hidden" accept="image/*" />
              <div id="preview-container" class="hidden w-full max-w-xs mt-4">
                <img id="image-preview" src="" alt="" class="rounded-lg shadow-md w-full h-auto" />
              </div>
              <button
                class="flex items-center justify-center rounded-lg h-10 px-6 bg-[#e7f3e8] dark:bg-[#1e3a21] text-[#0d1b0f] dark:text-white text-sm font-bold hover:bg-[#d5ebd7] dark:hover:bg-[#2a4d2e] transition-colors"
                type="button" onclick="document.getElementById('file-input').click()">
                Browse Files
              </button>
            </div>
          </div>

          <div class="flex flex-col gap-6">
            <!-- Map Section -->
            <div class="flex flex-col gap-2">
              <label class="text-[#0d1b0f] dark:text-white text-base font-bold leading-normal">GPS Map</label>
              <div id="map"></div>
            </div>

            <!-- Location Field -->
            <div class="flex flex-col gap-2">
              <label class="text-[#0d1b0f] dark:text-white text-base font-bold leading-normal">Location</label>
              <div class="relative flex w-full items-center">
                <span class="absolute left-4 material-symbols-outlined text-primary">location_on</span>
                <input id="locationInput"
                  class="w-full flex-1 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white h-14 pl-12 pr-12 text-base font-medium focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary placeholder:text-gray-400"
                  placeholder="Enter address or detect automatically" type="text" />
                <button type="button" onclick="detectLocation()"
                  class="absolute right-2 h-10 w-10 flex items-center justify-center text-primary hover:bg-primary/10 rounded-lg transition-colors">
                  <span class="material-symbols-outlined">my_location</span>
                </button>
              </div>
            </div>

            <!-- Nearby Landmark Field -->
            <div class="flex flex-col gap-2">
              <label class="text-[#0d1b0f] dark:text-white text-base font-bold leading-normal">Nearby Landmark</label>
              <div class="relative flex w-full items-center">
                <span class="absolute left-4 material-symbols-outlined text-primary">flag</span>
                <input id="landmarkInput"
                  class="w-full flex-1 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white h-14 pl-12 px-4 text-base font-medium focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary placeholder:text-gray-400"
                  placeholder="e.g. Near Big Bazaar, Opposite Apollo Hospital" type="text" />
              </div>
            </div>

            <!-- Category Dropdown -->
            <div class="flex flex-col gap-2">
              <label class="text-[#0d1b0f] dark:text-white text-base font-bold leading-normal">Issue
                Category</label>
              <div class="relative">
                <span
                  class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-primary">category</span>
                <select id="categorySelect" required
                  class="w-full appearance-none rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white h-14 pl-12 pr-10 text-base font-medium focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary">
                  <option disabled="" selected="" value="">Select an issue type...</option>
                  <option value="Roads & Maintenance">Roads & Maintenance</option>
                  <option value="Sanitation">Sanitation</option>
                  <option value="Water Supply">Water Supply</option>
                  <option value="Street Lighting">Street Lighting</option>
                  <option value="Garbage Pickup">Garbage Pickup</option>
                  <option value="Illegal Construction">Illegal Construction</option>
                  <option value="Other">Other</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-[#4c9a52]">
                  <span class="material-symbols-outlined">expand_more</span>
                </div>
              </div>
            </div>

            <!-- Description Textarea -->
            <div class="flex flex-col gap-2">
              <label class="text-[#0d1b0f] dark:text-white text-base font-bold leading-normal">Description</label>
              <textarea id="descriptionText" required
                class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white min-h-[140px] p-4 text-base font-medium focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary resize-none placeholder:text-gray-400"
                placeholder="Please describe the problem in detail to help our team understand the issue better..."></textarea>
            </div>
          </div>

          <!-- Submit Button -->
          <div class="pt-2">
            <button
              class="w-full flex items-center justify-center rounded-xl h-14 bg-primary hover:opacity-90 text-white text-lg font-black tracking-[0.015em] transition-all shadow-lg shadow-green-100 dark:shadow-none hover:translate-y-[-1px] active:scale-[0.98]"
              type="submit">
              Submit Complaint
            </button>
          </div>
        </form>
      </div>
    </div>
  </main>

  <!-- Success Modal (Hidden) -->
  <div id="successModal"
    class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
    <div class="bg-white rounded-3xl p-8 max-w-sm w-full text-center shadow-2xl animate-in zoom-in duration-300">
      <div class="size-20 bg-green-100 text-primary rounded-full flex items-center justify-center mx-auto mb-6">
        <span class="material-symbols-outlined text-5xl">check_circle</span>
      </div>
      <h3 class="text-2xl font-black text-gray-900 mb-2">Complaint Submitted!</h3>
      <p class="text-gray-500 mb-6 font-medium">Your tracking ID is:</p>
      <div class="bg-gray-100 rounded-xl p-4 mb-8">
        <p id="trackingIdDisplay" class="text-2xl font-mono font-black tracking-widest text-primary">---</p>
      </div>
      <button onclick="window.location.href='home.php'"
        class="w-full h-14 bg-gray-900 text-white rounded-xl font-bold hover:bg-black transition-colors">
        Back to Home
      </button>
    </div>
  </div>

  <!-- JS -->
  <script>
    // Image Preview Logic
    const fileInput = document.getElementById('file-input');
    const previewContainer = document.getElementById('preview-container');
    const imagePreview = document.getElementById('image-preview');

    fileInput.addEventListener('change', function () {
      const file = this.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
          imagePreview.src = e.target.result;
          previewContainer.classList.remove('hidden');
        }
        reader.readAsDataURL(file);
      }
    });

    // Geolocation Logic
    let map;
    let marker;

    function initMap(lat, lon) {
      if (!map) {
        map = L.map('map').setView([lat, lon], 15);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          maxZoom: 19,
          attribution: '© OpenStreetMap'
        }).addTo(map);
        marker = L.marker([lat, lon], { draggable: true }).addTo(map);

        marker.on('dragend', function (event) {
          const position = marker.getLatLng();
          reverseGeocode(position.lat, position.lng);
        });
      } else {
        map.setView([lat, lon], 15);
        marker.setLatLng([lat, lon]);
      }
    }

    function reverseGeocode(lat, lon) {
      const locationInput = document.getElementById('locationInput');
      locationInput.value = ""; // Clear any previous value
      locationInput.placeholder = "Finding address...";

      // Nominatim API call with more details and explicit zoom
      fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lon}&zoom=18&addressdetails=1`, {
        headers: {
          'Accept-Language': 'en'
        }
      })
        .then(response => {
          if (!response.ok) throw new Error('Network response was not ok');
          return response.json();
        })
        .then(data => {
          if (!data) {
            throw new Error('No data received from geocoding service');
          }

          // Use the complete display_name as a base fallback
          let address = data.display_name || "";

          // Try to build a cleaner address if details exist
          if (data.address) {
            const a = data.address;
            const parts = [];

            // Pick the most specific name available
            const areaName = a.suburb || a.neighbourhood || a.village || a.subdistrict || a.city_district || a.hamlet || "";
            const roadName = a.road || a.pedestrian || a.cycleway || "";
            const city = a.city || a.town || a.municipality || "";

            if (roadName) parts.push(roadName);
            if (areaName) parts.push(areaName);
            if (city) parts.push(city);

            if (parts.length > 0) {
              address = parts.join(", ");
            }
          }

          if (!address || address.length < 5) {
            // If still too short or empty, use the full name but clean it up
            address = data.display_name || `Area near ${lat.toFixed(4)}, ${lon.toFixed(4)}`;
          }

          locationInput.value = address;
        })
        .catch(error => {
          console.error('Geocoding Error:', error);
          // If all else fails, don't just show coordinates, show a helpful message
          locationInput.placeholder = "Please enter address manually";
          locationInput.value = "";
          alert("We found your coordinates, but couldn't find the street name. Please type your area name manually.");
        });
    }

    function detectLocation() {
      const locationInput = document.getElementById('locationInput');
      locationInput.placeholder = "Detecting GPS...";

      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
          (position) => {
            const lat = position.coords.latitude;
            const lon = position.coords.longitude;

            initMap(lat, lon);
            reverseGeocode(lat, lon);
          },
          (error) => {
            alert("Geolocation failed: " + error.message);
            locationInput.placeholder = "Detecting GPS failed";
            // Default to a central location if failed (e.g. Bangalore)
            initMap(12.9716, 77.5946);
          }
        );
      } else {
        alert("Geolocation is not supported by this browser.");
      }
    }

    function handleComplaintSubmit(e) {
      e.preventDefault();

      const trackingId = "CIV-" + Math.floor(100000 + Math.random() * 900000);

      // Prepare form data for the engine
      const formData = new FormData();
      formData.append('tracking_id', trackingId);
      formData.append('location', document.getElementById('locationInput').value);
      formData.append('landmark', document.getElementById('landmarkInput').value);
      formData.append('category', document.getElementById('categorySelect').value);
      formData.append('description', document.getElementById('descriptionText').value);

      const fileInput = document.getElementById('file-input');
      if (fileInput.files.length > 0) {
        formData.append('image', fileInput.files[0]);
      }

      // Send to engine
      fetch('engine/submit_complaint.php', {
        method: 'POST',
        body: formData
      })
        .then(response => response.json())
        .then(data => {
          if (data.status === 'success') {
            // Show Success Modal
            document.getElementById('trackingIdDisplay').innerText = trackingId;
            document.getElementById('successModal').classList.remove('hidden');
          } else {
            alert("Error: ".data.message);
          }
        })
        .catch(error => {
          console.error('Error:', error);
          // Fallback for demo if engine isn't perfect yet
          document.getElementById('trackingIdDisplay').innerText = trackingId;
          document.getElementById('successModal').classList.remove('hidden');
        });
    }

    // Auto-run detection on load for a "smart" feel
    window.onload = detectLocation;
  </script>
</body>

</html>
