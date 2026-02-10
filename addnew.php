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
    <title>CivicFix - Assign Responsibility</title>

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
    <main class="flex-1 p-6 max-w-4xl mx-auto w-full">

        <!-- PAGE TITLE -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Assign Responsibility</h2>
            <p class="text-gray-500">Choose which corporator or department handles each type of issue in a ward.</p>
        </div>

        <!-- FORM CARD -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-8 mb-6">
            <div class="flex items-center gap-2 mb-6 pb-4 border-b border-gray-200">
                <div class="size-8 rounded-full bg-primary flex items-center justify-center">
                    <span class="material-symbols-outlined text-white text-lg">add</span>
                </div>
                <h3 class="text-lg font-bold text-gray-900">Create New Assignment</h3>
            </div>

            <form id="assignmentForm" class="space-y-6">
                <!-- Area to be Covered & Issue Category Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Area to be Covered -->
                    <div>
                        <label for="areaCovered" class="block text-sm font-semibold text-gray-700 mb-2">Area to be
                            Covered</label>
                        <input id="areaCovered" type="text" required
                            placeholder="Enter area names (e.g., Ward 12, Downtown)"
                            class="w-full h-12 px-4 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary focus:outline-none text-gray-900" />
                    </div>

                    <!-- Issue Category -->
                    <div>
                        <label for="issueCategory" class="block text-sm font-semibold text-gray-700 mb-2">Issue
                            Category</label>
                        <select id="issueCategory" required
                            class="w-full h-12 px-4 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary focus:outline-none text-gray-900">
                            <option value="">Select Category</option>
                            <option value="Roads & Maintenance">Roads & Maintenance</option>
                            <option value="Sanitation">Sanitation</option>
                            <option value="Water Supply">Water Supply</option>
                            <option value="Street Lighting">Street Lighting</option>
                            <option value="Garbage Pickup">Garbage Pickup</option>
                            <option value="Illegal Construction">Illegal Construction</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>

                <!-- Corporator Name -->
                <div>
                    <label for="corporatorName" class="block text-sm font-semibold text-gray-700 mb-2">Corporator
                        Name</label>
                    <input id="corporatorName" type="text" required placeholder="Enter corporator or department name"
                        class="w-full h-12 px-4 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary focus:outline-none text-gray-900" />
                </div>

                <!-- Email & Password Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Email -->
                    <div>
                        <label for="corpEmail" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                        <input id="corpEmail" type="email" required placeholder="Enter login email"
                            class="w-full h-12 px-4 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary focus:outline-none text-gray-900" />
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="corpPassword"
                            class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                        <input id="corpPassword" type="password" required placeholder="Enter login password"
                            class="w-full h-12 px-4 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary focus:outline-none text-gray-900" />
                    </div>
                </div>

                <!-- Save Button -->
                <div class="pt-4">
                    <button type="submit"
                        class="flex items-center justify-center gap-2 h-12 px-8 bg-primary hover:opacity-90 text-white font-bold rounded-lg transition-colors">
                        <span class="material-symbols-outlined text-lg">check_circle</span>
                        <span>Save Assignment</span>
                    </button>
                </div>
            </form>
        </div>



    </main>

    <!-- FOOTER -->
    <footer class="px-6 py-6 border-t border-gray-200 bg-white mt-auto">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-sm text-gray-400">Municipal Management System v2.0 - Admin Dashboard</p>
            <a href="corporators.php" class="text-sm text-green-600 font-semibold hover:underline">← Back to
                Corporators</a>
        </div>
    </footer>

    <!-- JAVASCRIPT -->
    <script>
        // Handle form submission
        document.getElementById('assignmentForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData();
            formData.append('coverage', document.getElementById('areaCovered').value);
            formData.append('category', document.getElementById('issueCategory').value);
            formData.append('name', document.getElementById('corporatorName').value);
            formData.append('email', document.getElementById('corpEmail').value);
            formData.append('password', document.getElementById('corpPassword').value);

            fetch('engine/add_corporator.php', {
                method: 'POST',
                body: formData
            })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert(data.message);
                        window.location.href = 'corporators.php';
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(err => {
                    console.error('Error:', err);
                    alert('An error occurred. Please try again.');
                });
        });


    </script>

</body>

</html>
