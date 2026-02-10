<!DOCTYPE html>
<html lang="en" class="light">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CivicConnect – Check Status</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;700&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    body {
      font-family: "Public Sans", sans-serif;
    }
  </style>

  <script id="tailwind-config">
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            "primary": "#45B25C",
            "accent-green": "#45B25C",
          },
        },
      },
    }
  </script>
</head>

<body class="bg-gray-50 min-h-screen flex flex-col">

  <!-- HEADER -->
  <header class="border-b bg-white px-6 py-3 flex items-center gap-3">
    <span class="material-symbols-outlined text-primary mr-2">admin_panel_settings</span>
    <h1 class="text-lg font-bold">CivicFix</h1>
  </header>

  <!-- MAIN -->
  <main class="flex-1 flex flex-col items-center px-4 py-10 gap-8">

    <!-- SEARCH CARD -->
    <section class="w-full max-w-xl bg-white border rounded-xl shadow p-8 text-center">
      <span class="material-symbols-outlined text-primary text-4xl mb-3">search</span>

      <h2 class="text-2xl font-bold mb-2">Track Your Request</h2>
      <p class="text-gray-600 mb-6">
        Enter your complaint ID to check the current status.
      </p>

      <div class="flex flex-col sm:flex-row gap-3">
        <input id="trackId" type="text" placeholder="e.g. CIVIC-2023-8492"
          class="flex-1 h-12 border rounded-lg px-4 font-mono focus:ring-2 focus:ring-primary focus:outline-none" />
        <button onclick="checkStatus()" class="h-12 bg-primary hover:opacity-90 text-white font-bold px-6 rounded-lg">
          Check Status
        </button>
      </div>

      <p class="text-xs text-gray-500 mt-3">
        You received this ID after submitting the complaint.
      </p>
    </section>

    <!-- STATUS CARD -->
    <section id="statusCard" class="w-full max-w-3xl hidden">
      <div class="bg-white border rounded-xl shadow overflow-hidden">

        <!-- HEADER -->
        <div class="p-6 border-b flex flex-col sm:flex-row sm:items-center justify-between gap-4">
          <div>
            <h3 id="complaintId" class="text-xl font-bold"></h3>
            <p id="submittedDate" class="text-sm text-gray-500"></p>
          </div>

          <!-- STATUS BADGE -->
          <span id="statusBadge" class="px-4 py-2 rounded-full text-sm font-bold">
          </span>
        </div>

        <!-- BODY -->
        <div class="p-6 space-y-6">

          <!-- RESOLUTION MESSAGE -->
          <div>
            <h4 class="text-sm font-bold uppercase text-gray-500 mb-2">
              Resolution Message
            </h4>
            <p id="resolutionMessage" class="text-gray-700">
              <!-- engine text only -->
            </p>
          </div>

          <!-- PROOF IMAGE -->
          <div>
            <h4 class="text-sm font-bold uppercase text-gray-500 mb-2">
              Proof of Resolution
            </h4>

            <div id="proofContainer"
              class="w-full h-56 border rounded-lg flex items-center justify-center text-gray-400">
              No proof uploaded yet
            </div>
          </div>

          <!-- LAST UPDATED -->
          <p id="lastUpdated" class="text-xs text-gray-500"></p>

        </div>
      </div>
    </section>

  </main>

  <!-- FOOTER -->
  <footer class="border-t py-6 text-center text-sm text-gray-500 bg-white">
    © 2024 CivicConnect
  </footer>

  <!-- JS (engine READY) -->
  <script>
    function checkStatus() {
      const id = document.getElementById("trackId").value.trim();
      if (!id) {
        alert("Please enter a complaint ID");
        return;
      }

      // engine CALL
      fetch(`engine/get_status.php?id=${encodeURIComponent(id)}`)
        .then(res => res.json())
        .then(data => {
          if (data.status_code === 'success') {
            renderStatus(data);
          } else {
            alert(data.message || "Complaint not found");
          }
        })
        .catch(() => alert("Unable to fetch status"));
    }

    function renderStatus(data) {
      document.getElementById("complaintId").innerText =
        "Complaint #" + data.complaint_id;

      document.getElementById("submittedDate").innerText =
        "Submitted on " + data.submitted_date;

      const badge = document.getElementById("statusBadge");

      if (data.status === "Resolved") {
        badge.innerText = "Resolved";
        badge.className =
          "px-4 py-2 rounded-full text-sm font-bold bg-primary/10 text-primary";
      } else {
        badge.innerText = "Pending";
        badge.className =
          "px-4 py-2 rounded-full text-sm font-bold bg-yellow-100 text-yellow-800";
      }

      document.getElementById("resolutionMessage").innerText =
        data.work_notes || "Work not completed yet.";

      const proof = document.getElementById("proofContainer");
      if (data.work_image) {
        proof.innerHTML = `
      <img src="${data.work_image}"
           class="w-full h-full object-cover rounded-lg"
           alt="Work proof">
    `;
      } else {
        proof.innerText = "No proof uploaded yet";
      }

      document.getElementById("lastUpdated").innerText =
        data.last_updated ? "Last updated: " + data.last_updated : "";

      document.getElementById("statusCard").classList.remove("hidden");
    }
  </script>

</body>

</html>
