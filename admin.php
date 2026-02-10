<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header("Location: login.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CivicFix Admin Dashboard</title>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap"
    rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined&display=swap" rel="stylesheet" />

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
  <header class="bg-white border-b h-16 flex items-center justify-between px-6">
    <div class="flex items-center gap-2">
      <span class="material-symbols-outlined text-primary mr-2">admin_panel_settings</span>
      <h1 class="font-bold text-lg">CivicFix</h1>
    </div>
    <nav class="flex items-center gap-4">
      <a href="admin.php" class="text-sm font-semibold text-primary hover:text-primary/90 flex items-center gap-1">
        <span class="material-symbols-outlined text-lg">dashboard</span>
        Dashboard
      </a>
      <a href="corporators.php" class="text-sm font-semibold text-gray-600 hover:text-primary flex items-center gap-1">
        <span class="material-symbols-outlined text-lg">group</span>
        Corporators
      </a>
      <a href="engine/logout.php" class="text-sm font-semibold text-red-600 hover:text-red-700 flex items-center gap-1">
        <span class="material-symbols-outlined text-lg">logout</span>
        Logout
      </a>
    </nav>
  </header>

  <!-- MAIN -->
  <main class="flex-1 p-6 max-w-7xl mx-auto w-full">

    <!-- PAGE TITLE -->
    <div class="mb-6">
      <h2 class="text-2xl font-bold text-gray-900">Admin Dashboard</h2>
      <p class="text-gray-500 text-sm">Complaints requiring your action.</p>
    </div>

    <!-- SECTION NAVIGATION TABS -->
    <div class="flex items-center gap-1 bg-gray-100 p-1.5 rounded-2xl w-fit mb-10 shadow-sm border border-gray-200">
      <button onclick="filterByStatus('new')" id="btn-new"
        class="px-10 py-3 bg-primary text-white text-sm font-extrabold rounded-xl transition-all shadow-md tracking-wider flex items-center gap-2">
        <span class="material-symbols-outlined text-lg">public</span>
        ISSUES
      </button>
      <button onclick="filterByStatus('review')" id="btn-review"
        class="px-10 py-3 text-gray-500 hover:text-gray-700 text-sm font-extrabold rounded-xl transition-all hover:bg-gray-50 tracking-wider flex items-center gap-2">
        <span class="material-symbols-outlined text-lg">verified</span>
        REVIEW
      </button>
    </div>

    <!-- DASHBOARD SECTIONS -->
    <div class="space-y-12">

      <!-- PENDING ISSUES SECTION (CITIZEN COMPLAINTS) -->
      <section id="pending-issues-section">
        <div class="flex items-center gap-2 mb-4">
          <span class="material-symbols-outlined text-primary">report_problem</span>
          <h3 class="text-xl font-bold text-gray-900">Citizen Complaints</h3>
          <span
            class="flex items-center justify-center bg-primary/10 text-primary text-xs font-bold px-2 py-0.5 rounded-full">3</span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="issues-grid">
          <!-- Complaints will be loaded here via JS -->
        </div>
      </section>

      <!-- UNDER REVIEW SECTION -->
      <section id="under-review-section" class="hidden">
        <div class="flex items-center gap-2 mb-4">
          <span class="material-symbols-outlined text-orange-500">pending_actions</span>
          <h3 class="text-xl font-bold text-gray-900">Review Work</h3>
          <span id="review-count"
            class="flex items-center justify-center bg-orange-100 text-orange-700 text-xs font-bold px-2 py-0.5 rounded-full">0</span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="review-grid">
          <!-- Review items will be loaded here via JS -->
        </div>
      </section>
    </div>
  </main>

  <!-- JAVASCRIPT -->
  <script>
    function filterByStatus(status) {
      const issuesSection = document.getElementById('pending-issues-section');
      const reviewSection = document.getElementById('under-review-section');
      const btnNew = document.getElementById('btn-new');
      const btnReview = document.getElementById('btn-review');

      const activeClass = 'px-10 py-3 bg-green-500 text-white text-sm font-extrabold rounded-xl transition-all shadow-md tracking-wider flex items-center gap-2';
      const inactiveClass = 'px-10 py-3 text-gray-500 hover:text-gray-700 text-sm font-extrabold rounded-xl transition-all hover:bg-gray-50 tracking-wider flex items-center gap-2';

      if (status === 'new') {
        issuesSection.classList.remove('hidden');
        reviewSection.classList.add('hidden');
        btnNew.className = activeClass;
        btnReview.className = inactiveClass;
      } else {
        issuesSection.classList.add('hidden');
        reviewSection.classList.remove('hidden');
        btnNew.className = inactiveClass;
        btnReview.className = activeClass;
      }
    }

    function assignComplaint(id, category, locationVal, landmark, locationAddr, description) {
      // Transitioning to engine: Use URL parameter instead of localStorage
      window.location.href = 'assign.php?id=' + encodeURIComponent(id);
    }

    function reviewWork(id, category, location, landmark, origImage, origDoc, workImage, workNotes) {
      // Transitioning to engine: Use URL parameter instead of localStorage
      window.location.href = 'review.php?id=' + encodeURIComponent(id);
    }

    // LOAD COMPLAINTS FROM engine
    function loadComplaints() {
      fetch('engine/get_complaints.php')
        .then(res => res.json())
        .then(data => {
          const issueGrid = document.getElementById('issues-grid');
          const reviewGrid = document.getElementById('review-grid');
          const issueBadge = document.querySelector('#pending-issues-section .bg-primary\\/10');
          const reviewBadge = document.getElementById('review-count');

          issueGrid.innerHTML = '';
          reviewGrid.innerHTML = '';

          let pendingCount = 0;
          let reviewCount = 0;

          data.forEach(c => {
            if (c.status === 'Pending Investigation') {
              pendingCount++;
              issueGrid.appendChild(createComplaintCard(c));
            } else if (c.status === 'Under Review') {
              reviewCount++;
              reviewGrid.appendChild(createReviewCard(c));
            }
          });

          issueBadge.innerText = pendingCount;
          reviewBadge.innerText = reviewCount;

          if (reviewCount > 0) {
            document.getElementById('under-review-section').classList.remove('hidden');
          }
        })
        .catch(err => console.error('Error loading complaints:', err));
    }

    function createReviewCard(c) {
      const article = document.createElement('article');
      article.className = 'complaint-card bg-white rounded-xl border-2 border-green-500 shadow-md overflow-hidden flex flex-col';

      article.innerHTML = `
        <div class="relative h-48 overflow-hidden">
          <img class="w-full h-full object-cover" src="${c.image_path || 'https://via.placeholder.com/400x200?text=No+Image'}" alt="Review Image" />
          <div class="absolute top-3 left-3">
            <span class="bg-white/90 backdrop-blur px-2 py-1 rounded text-[10px] font-bold text-gray-600">#${c.tracking_id}</span>
          </div>
          <div class="absolute top-3 right-3">
            <span class="bg-orange-500 text-white px-2 py-1 rounded text-[10px] font-bold uppercase">REVIEW</span>
          </div>
        </div>
        <div class="p-5 flex-1 flex flex-col gap-4">
          <div>
            <div class="text-[11px] font-bold text-green-600 uppercase mb-1">${c.category}</div>
            <h3 class="text-lg font-bold text-gray-900 leading-tight">Work Submitted</h3>
            <div class="flex items-center gap-1.5 mt-2 text-gray-500 text-sm">
              <span class="material-symbols-outlined text-base">location_on</span>
              <span class="truncate">${c.location}</span>
            </div>
          </div>
        </div>
        <div class="px-5 pb-5">
          <button onclick="reviewWork('${c.tracking_id}')" 
            class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-2.5 rounded-lg text-sm flex items-center justify-center gap-2">
            <span class="material-symbols-outlined text-lg">verified</span> Review Work
          </button>
        </div>
      `;
      return article;
    }

    function createComplaintCard(c) {
      const article = document.createElement('article');
      article.className = 'complaint-card bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden flex flex-col';

      article.innerHTML = `
        <div class="relative h-48 overflow-hidden">
          <img class="w-full h-full object-cover" src="${c.image_path || 'https://via.placeholder.com/400x200?text=No+Image'}" alt="Issue Image" />
          <div class="absolute top-3 left-3">
            <span class="bg-white/90 backdrop-blur px-2 py-1 rounded text-[10px] font-bold text-gray-600">#${c.tracking_id}</span>
          </div>
          <div class="absolute top-3 right-3">
            <span class="bg-blue-600 text-white px-2 py-1 rounded text-[10px] font-bold uppercase">${c.status}</span>
          </div>
        </div>
        <div class="p-5 flex-1 flex flex-col gap-4">
          <div>
            <div class="text-[11px] font-bold text-primary uppercase mb-1">${c.category}</div>
            <h3 class="text-lg font-bold text-gray-900 leading-tight">${c.landmark || 'New Issue'}</h3>
            <div class="flex items-center gap-1.5 mt-2 text-gray-500 text-sm">
              <span class="material-symbols-outlined text-base">location_on</span>
              <span class="truncate">${c.location}</span>
            </div>
          </div>
        </div>
        <div class="px-5 pb-5">
          <button onclick="assignComplaint('${c.tracking_id}')" 
            class="w-full bg-primary hover:opacity-90 text-white font-bold py-2.5 rounded-lg text-sm flex items-center justify-center gap-2">
            <span class="material-symbols-outlined text-lg">send</span> Assign Issue
          </button>
        </div>
      `;
      return article;
    }

    window.onload = loadComplaints;
  </script>

</body>

</html>
