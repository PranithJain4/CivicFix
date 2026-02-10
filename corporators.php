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
    <title>CivicFix - Manage Corporators</title>

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
            <a href="admin.php" class="text-sm font-semibold text-gray-600 hover:text-primary flex items-center gap-1">
                <span class="material-symbols-outlined text-lg">dashboard</span>
                Dashboard
            </a>
            <a href="corporators.php"
                class="text-sm font-semibold text-primary hover:text-primary/90 flex items-center gap-1">
                <span class="material-symbols-outlined text-lg">group</span>
                Corporators
            </a>
            <a href="engine/logout.php"
                class="text-sm font-semibold text-red-600 hover:text-red-700 flex items-center gap-1">
                <span class="material-symbols-outlined text-lg">logout</span>
                Logout
            </a>
        </nav>
    </header>

    <!-- MAIN -->
    <main class="flex-1 p-6 max-w-7xl mx-auto w-full">

        <!-- PAGE TITLE & ACTION -->
        <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Manage Corporators</h2>
                <p class="text-gray-500 text-sm">Add, view, and manage corporators assigned to wards or departments.</p>
            </div>
            <a href="addnew.php"
                class="flex items-center justify-center gap-2 h-11 px-6 bg-primary hover:opacity-90 text-white text-sm font-bold rounded-lg whitespace-nowrap">
                <span class="material-symbols-outlined text-[20px]">person_add</span>
                <span>Add New Corporator</span>
            </a>
        </div>

        <!-- SEARCH BAR -->
        <div class="mb-6">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                    <span class="material-symbols-outlined">search</span>
                </div>
                <input id="searchInput" type="text" placeholder="Search by corporator name"
                    class="w-full h-12 pl-12 pr-4 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary focus:outline-none" />
            </div>
        </div>

        <!-- TABLE -->
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-wider text-green-600">
                                Corporator Name</th>
                            <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-wider text-green-600">
                                Category</th>
                            <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-wider text-green-600">Assigned
                                Coverage</th>
                            <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-wider text-red-600">
                                Delete</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100" id="corporatorsTable">
                        <!-- Rows will be populated by JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- EMPTY STATE (shown when no results) -->
        <div id="emptyState" class="hidden bg-white rounded-xl border border-gray-200 p-12 text-center">
            <span class="material-symbols-outlined text-gray-300 text-5xl mb-3">search_off</span>
            <h3 class="text-lg font-bold text-gray-900 mb-1">No corporators found</h3>
            <p class="text-gray-500 text-sm">Try adjusting your search or add a new corporator.</p>
        </div>

    </main>

    <!-- FOOTER -->
    <footer class="px-6 py-6 border-t border-gray-200 bg-white mt-auto">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-sm text-gray-400">© 2024 CivicFix. All rights reserved.</p>
            <div class="flex gap-6">
                <a class="text-sm text-gray-400 hover:text-green-600 transition-colors" href="#">Privacy Policy</a>
                <a class="text-sm text-gray-400 hover:text-green-600 transition-colors" href="#">Support Center</a>
                <a class="text-sm text-gray-400 hover:text-green-600 transition-colors" href="#">System Status</a>
            </div>
        </div>
    </footer>

    <!-- JAVASCRIPT -->
    <script>
        // Placeholder corporators data (Future: Fetch from PHP/MySQL)
        let corporators = [];

        function loadCorporators() {
            fetch('engine/get_corporators.php')
                .then(res => res.json())
                .then(data => {
                    corporators = data;
                    renderCorporators(data);
                })
                .catch(err => console.error('Error loading corporators:', err));
        }

        // Render corporators table
        function renderCorporators(data) {
            const tbody = document.getElementById('corporatorsTable');
            const emptyState = document.getElementById('emptyState');

            if (data.length === 0) {
                tbody.innerHTML = '';
                emptyState.classList.remove('hidden');
                return;
            }

            emptyState.classList.add('hidden');

            tbody.innerHTML = data.map(corp => `
        <tr class="hover:bg-gray-50 transition-colors">
          <td class="px-6 py-5">
            <span class="font-semibold text-gray-900">${corp.name}</span>
          </td>
          <td class="px-6 py-5 text-sm text-gray-600">${corp.category}</td>
          <td class="px-6 py-5 text-sm text-gray-600">${corp.coverage}</td>
          <td class="px-6 py-5">
            <button onclick="deleteCorporator('${corp.id}', '${corp.name}')" class="text-red-600 text-sm font-bold hover:underline">
              Delete
            </button>
          </td>
        </tr>
      `).join('');
        }

        // Search functionality
        const searchInput = document.getElementById('searchInput');
        searchInput.addEventListener('input', (e) => {
            const query = e.target.value.toLowerCase();
            const filtered = corporators.filter(corp =>
                corp.name.toLowerCase().includes(query) ||
                corp.coverage.toLowerCase().includes(query)
            );
            renderCorporators(filtered);
        });

        // Manage/Edit corporator
        function manageCorporator(name) {
            alert("Editing " + name + " (engine required)");
        }

        // Delete corporator
        function deleteCorporator(id, name) {
            if (confirm(`Are you sure you want to delete corporator: ${name}?`)) {
                const formData = new FormData();
                formData.append('id', id);

                fetch('engine/delete_corporator.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success') {
                            alert(data.message);
                            loadCorporators();
                        } else {
                            alert('Error: ' + data.message);
                        }
                    })
                    .catch(err => console.error('Error deleting:', err));
            }
        }

        // Initial render
        loadCorporators();
    </script>

</body>

</html>
