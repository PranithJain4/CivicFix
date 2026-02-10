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
    <title>CivicFix - Assign Complaint</title>

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

        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
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

<body class="bg-[#F8FAFC] min-h-screen flex flex-col">

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
                class="text-sm font-semibold text-gray-600 hover:text-primary flex items-center gap-1">
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
    <main class="flex-1 p-6 lg:p-12 max-w-7xl mx-auto w-full">

        <!-- PAGE TITLE -->
        <div class="mb-10">
            <div class="flex items-center gap-3 mb-2">
                <h2 class="text-3xl font-extrabold text-[#111827]">Assign Complaint</h2>
                <span
                    class="bg-orange-100 text-orange-700 text-[10px] font-bold px-2.5 py-1 rounded uppercase tracking-wider">Pending
                    Assignment</span>
            </div>
            <p class="text-gray-500 font-medium">Review the complaint and select a corporator to handle the task.</p>
        </div>

        <!-- CONTENT GRID -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">

            <!-- LEFT COLUMN: COMPLAINT SUMMARY -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8 flex flex-col gap-8">
                <div class="flex items-center gap-3 pb-4 border-b border-gray-100">
                    <span class="material-symbols-outlined text-primary bg-primary/10 p-2 rounded-lg">description</span>
                    <h3 class="font-bold text-lg text-gray-900">Complaint Summary</h3>
                </div>

                <div class="grid grid-cols-2 gap-y-8 gap-x-4">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Complaint ID</p>
                        <p id="comp-id" class="text-sm font-bold text-gray-900">#---</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Category</p>
                        <p id="comp-category" class="text-sm font-bold text-gray-900">---</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Location</p>
                        <p id="comp-area" class="text-sm font-bold text-gray-900">---</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Landmark</p>
                        <p id="comp-district" class="text-sm font-bold text-gray-900">---</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Address</p>
                        <p id="comp-location" class="text-sm font-bold text-gray-900 leading-relaxed">---</p>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-xl p-6 border border-gray-100">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">Citizen Description
                    </p>
                    <p id="comp-description" class="text-sm text-gray-600 leading-relaxed italic">"---"</p>
                </div>
            </div>

            <!-- RIGHT COLUMN: ASSIGNED TO -->
            <div class="space-y-6">
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="p-8 border-b border-gray-100">
                        <div class="flex items-center gap-3 mb-8">
                            <span
                                class="material-symbols-outlined text-primary bg-primary/10 p-2 rounded-lg">person_search</span>
                            <h3 class="font-bold text-lg text-gray-900">Selected Corporator</h3>
                        </div>

                        <!-- Corporator Card -->
                        <div id="selected-corp-card"
                            class="bg-[#F9FAFB] border border-gray-200 rounded-2xl p-6 mb-8 flex items-start gap-4">
                            <div
                                class="size-14 bg-white rounded-xl shadow-sm border border-gray-100 flex items-center justify-center">
                                <span class="material-symbols-outlined text-primary text-3xl">engineering</span>
                            </div>
                            <div class="flex-1">
                                <h4 id="corp-name" class="font-extrabold text-xl text-gray-900 mb-1">Select an Entity
                                </h4>
                                <p id="corp-meta" class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Loading system recommendation...</p>

                                <div class="mt-4 space-y-3">
                                    <div class="flex items-center gap-2 text-sm text-gray-600">
                                        <span class="material-symbols-outlined text-base">domain</span>
                                        <span id="corp-type" class="font-medium">---</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-sm text-gray-600">
                                        <span class="material-symbols-outlined text-base">map</span>
                                        <span id="corp-coverage" class="font-medium truncate">---</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button onclick="confirmAssignment()"
                            class="w-full h-16 bg-primary hover:opacity-90 text-white font-extrabold rounded-2xl shadow-lg shadow-green-100 transition-all flex items-center justify-center gap-3">
                            <span class="material-symbols-outlined">how_to_reg</span>
                            <span>Confirm & Assign</span>
                        </button>

                        <div class="text-center mt-6">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Or pick from the
                                list below</p>
                        </div>
                    </div>
                </div>

                <!-- SELECTION LIST (VISIBLE BY DEFAULT) -->
                <div id="selection-list"
                    class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 max-h-[500px] overflow-y-auto space-y-3">
                    <p class="text-sm font-bold text-gray-900 mb-4 px-2">Corporator Directory</p>
                    <div id="corp-options" class="space-y-2">
                        <!-- Populated by JS -->
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="p-6 text-center text-xs text-gray-400 mt-auto border-t border-gray-100">
        <div class="flex justify-center gap-6 mb-2">
            <a href="#" class="hover:text-green-600 underline decoration-gray-200">Support</a>
            <a href="#" class="hover:text-green-600 underline decoration-gray-200">Privacy Policy</a>
        </div>
        <p>CivicFlow Management Suite · Admin Dashboard v2.4</p>
    </footer>

    <script>
        let currentCorporators = [];

        function loadData() {
            const urlParams = new URLSearchParams(window.location.search);
            const complaintId = urlParams.get('id');

            if (!complaintId) {
                window.location.href = 'admin.php';
                return;
            }

            // Fetch Complaint Details
            fetch(`engine/get_status.php?id=${encodeURIComponent(complaintId)}`)
                .then(res => res.json())
                .then(data => {
                    if (data.status_code === 'success') {
                        complaint = data;
                        displayComplaint(data);
                    } else {
                        alert("Complaint not found");
                        window.location.href = 'admin.php';
                    }
                });

            // Fetch Corporators List
            fetch('engine/get_corporators.php')
                .then(res => res.json())
                .then(data => {
                    currentCorporators = data;
                    populateAlternativeList(data);
                });

            displayCorporator({
                name: "None Selected",
                category: "Please select from the list",
                coverage: "Use the directory below",
                type: "Status"
            });
        }

        function displayComplaint(data) {
            document.getElementById('comp-id').textContent = data.complaint_id;
            document.getElementById('comp-category').textContent = data.category;
            document.getElementById('comp-area').textContent = data.location.split(',').pop().trim() || "Local Area";
            document.getElementById('comp-district').textContent = data.landmark || "N/A";
            document.getElementById('comp-location').textContent = data.location;
            document.getElementById('comp-description').textContent = '"' + data.description + '"';
        }

        function displayCorporator(corp) {
            document.getElementById('corp-name').textContent = corp.name;
            document.getElementById('corp-meta').textContent = corp.category + ' | ' + (corp.type || 'Provider');
            document.getElementById('corp-type').textContent = corp.category;
            document.getElementById('corp-coverage').textContent = corp.coverage;
        }

        function populateAlternativeList(corps) {
            const container = document.getElementById('corp-options');
            container.innerHTML = corps.map(corp => `
        <button onclick="selectCorp('${corp.name}')" class="w-full flex items-center justify-between p-4 rounded-xl border border-gray-100 hover:border-green-500 hover:bg-green-50 transition-all text-left">
          <div>
            <p class="font-bold text-gray-900 text-sm">${corp.name}</p>
            <p class="text-[10px] text-gray-500 font-bold uppercase">${corp.category}</p>
          </div>
          <span class="material-symbols-outlined text-green-600 text-lg">add_circle</span>
        </button>
      `).join('');
        }

        function selectCorp(name) {
            selectedCorp = currentCorporators.find(c => c.name === name);
            if (selectedCorp) {
                displayCorporator(selectedCorp);
            }
        }

        function toggleSelection() {
            const list = document.getElementById('selection-list');
            list.classList.toggle('hidden');
            if (!list.classList.contains('hidden')) {
                list.scrollIntoView({ behavior: 'smooth' });
            }
        }

        function confirmAssignment() {
            if (!selectedCorp || selectedCorp.name === "None Selected") {
                alert("Please select a corporator first!");
                return;
            }

            const formData = new FormData();
            formData.append('complaint_id', complaint.complaint_id);
            formData.append('corporator_id', selectedCorp.id);

            fetch('engine/assign_issue.php', {
                method: 'POST',
                body: formData
            })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert(`Complaint ${complaint.complaint_id} successfully assigned to ${selectedCorp.name}!`);
                        window.location.href = 'admin.php';
                    } else {
                        alert("Error: " + data.message);
                    }
                })
                .catch(err => console.error('Error assigning:', err));
        }

        window.onload = loadData;
    </script>

</body>

</html>
