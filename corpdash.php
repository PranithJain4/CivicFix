<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'corporator') {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CivicFix - Corporator Dashboard</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <script id="tailwind-config">
        tailwind.config = {
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
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        body {
            font-family: 'Public Sans', sans-serif;
            background-color: #f8fafc;
        }

        .btn-update {
            background-color: #45B25C;
            transition: all 0.2s ease;
        }

        .btn-update:hover {
            background-color: #389a4d;
            transform: translateY(-1px);
        }
    </style>
</head>

<body class="min-h-screen flex flex-col">

    <!-- HEADER -->
    <header
        class="sticky top-0 z-50 w-full bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between">
        <div class="flex items-center">
            <!-- BRANDING: Same as other pages -->
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-accent-green text-3xl">admin_panel_settings</span>
                <h1 class="font-bold text-xl text-gray-900 tracking-tight">CivicFix</h1>
            </div>
        </div>
        <a href="engine/logout.php"
            class="text-sm font-semibold text-red-600 hover:text-red-700 flex items-center gap-1">
            <span class="material-symbols-outlined text-lg">logout</span>
            Logout
        </a>
    </header>

    <!-- MAIN -->
    <main class="max-w-6xl mx-auto px-6 py-12 w-full">
        <!-- PAGE TITLE & FILTER -->
        <div class="mb-12">
            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">My Assigned Tasks</h2>
        </div>

        <!-- TASKS GRID -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="tasks-grid">
            <!-- Tasks will be loaded here via JS -->
        </div>
    </main>

    <!-- FOOTER -->
    <footer
        class="max-w-6xl mx-auto px-6 py-12 border-t border-gray-200 mt-auto flex flex-col md:flex-row justify-between items-center gap-6">
        <p class="text-gray-400 text-[10px] font-extrabold uppercase tracking-widest">© 2026 Admin Management Portal ·
            CivicFix</p>
        <div class="flex gap-10">
            <a class="text-gray-400 hover:text-accent-green text-[10px] font-extrabold uppercase tracking-widest transition-colors"
                href="#">Support</a>
            <a class="text-gray-400 hover:text-accent-green text-[10px] font-extrabold uppercase tracking-widest transition-colors"
                href="#">Legal</a>
            <a class="text-gray-400 hover:text-accent-green text-[10px] font-extrabold uppercase tracking-widest transition-colors"
                href="#">Resources</a>
        </div>
    </footer>

    <script>
        function triggerUpdate(id) {
            window.location.href = 'update.php?id=' + encodeURIComponent(id);
        }

        function loadTasks() {
            fetch('engine/get_assigned_tasks.php')
                .then(res => res.json())
                .then(data => {
                    const grid = document.getElementById('tasks-grid');
                    grid.innerHTML = '';

                    if (data.length === 0) {
                        grid.innerHTML = '<div class="col-span-full text-center py-20 text-gray-500">No tasks assigned yet.</div>';
                        return;
                    }

                    data.forEach(task => {
                        grid.appendChild(createTaskCard(task));
                    });
                })
                .catch(err => console.error('Error loading tasks:', err));
        }

        function createTaskCard(task) {
            const div = document.createElement('div');
            div.className = "bg-white rounded-2xl border border-gray-100 p-8 flex flex-col justify-between shadow-sm hover:shadow-md transition-all h-full";

            div.innerHTML = `
                <div class="space-y-5">
                    <div class="border-b border-gray-50 pb-4">
                        <span class="text-[11px] font-extrabold text-accent-green uppercase tracking-widest">${task.category}</span>
                        <h3 class="text-gray-900 text-2xl font-black tracking-tight mt-1">#${task.tracking_id}</h3>
                    </div>

                    <div class="space-y-3">
                        <div class="flex items-start gap-2.5 text-gray-600">
                            <span class="material-symbols-outlined text-xl mt-0.5 shrink-0 text-gray-400">location_on</span>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Location</p>
                                <p class="text-sm font-bold text-gray-800 leading-snug">${task.location}</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-2.5 text-gray-600">
                            <span class="material-symbols-outlined text-xl mt-0.5 shrink-0 text-gray-400">map</span>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Landmark</p>
                                <p class="text-sm font-bold text-gray-800 leading-snug">${task.landmark}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-10">
                    <button onclick="triggerUpdate('${task.tracking_id}')"
                        class="btn-update w-full text-white py-4.5 rounded-2xl font-extrabold text-sm shadow-lg shadow-green-100 flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-lg">edit_note</span>
                        <span>UPDATE WORK</span>
                    </button>
                </div>
            `;
            return div;
        }

        window.onload = loadTasks;
    </script>

</body>

</html>
