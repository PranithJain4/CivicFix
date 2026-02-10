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
    <title>CivicFix - Review Work</title>

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

<body class="bg-[#F8FAFC] min-h-screen flex flex-col">

    <!-- HEADER (Simplified as requested) -->
    <header class="bg-white border-b h-16 flex items-center justify-between px-6">
        <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-primary mr-2">admin_panel_settings</span>
            <h1 class="font-bold text-lg text-gray-900">CivicFix</h1>
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
    <main class="flex-1 p-6 lg:p-12 max-w-5xl mx-auto w-full">

        <!-- PAGE TITLE -->
        <div class="mb-10">
            <h2 class="text-3xl font-extrabold text-[#111827] mb-2">Review Work Submission</h2>
            <p class="text-gray-500 font-medium">Verify completed work and take action.</p>
        </div>

        <!-- SUMMARY BAR -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 mb-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Complaint ID</p>
                    <p id="review-id" class="text-xs font-bold text-gray-900">---</p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Category</p>
                    <p id="review-category" class="text-xs font-bold text-gray-900">---</p>
                </div>
                <div>
                    <p id="location-label" class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">
                        Location</p>
                    <p id="review-location" class="text-xs font-bold text-gray-900">---</p>
                </div>
                <div>
                    <p id="landmark-label" class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">
                        Landmark</p>
                    <p id="review-landmark" class="text-xs font-bold text-gray-900">---</p>
                </div>
            </div>
        </div>

        <!-- ORIGINAL ISSUE SECTION -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden mb-8">
            <div class="bg-gray-50/50 px-6 py-3 border-b border-gray-100">
                <h3 class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Original Issue (Reported by
                    Citizen)</h3>
            </div>
            <div class="p-6 flex flex-col md:flex-row gap-8">
                <div class="md:w-1/2">
                    <img id="orig-image" class="w-full rounded-xl object-cover aspect-video shadow-sm"
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuB7rVX167Uj43BaIBxHjVxbYdydgMGSl933PKo9H4Y7ZyYAkp1uggN3u4yfQFn_pUYsa9jHX6AgBYxHUs-Yztw_rtGfBGRSBtKSfqolv0oe3H3cmhyn75GGIYELch5gWf7aAUX1lu1JvrFZviDA4rRCwTQ1B8KjO5SYoOzTboaxTS-Crt5EKyLvuSLQ8MkHn6SZn_EzVMNsfDcPL9dpvsmz_M7BQFMkntRK8Htji7DUOPzP_mbxak5Ky7IVK5b7g3zjlCH4dSL40pg"
                        alt="Original Issue" />
                </div>
                <div class="md:w-1/2 py-2">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">Issue Description</p>
                    <p id="orig-description" class="text-sm text-gray-600 leading-relaxed italic">
                        "---"
                    </p>
                </div>
            </div>
        </div>

        <!-- COMPLETED WORK SECTION -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden mb-12">
            <div class="bg-gray-50/50 px-6 py-3 border-b border-gray-100">
                <h3 class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Completed Work (Submitted by
                    Corporator)</h3>
            </div>
            <div class="p-6 flex flex-col md:flex-row gap-8">
                <div class="md:w-1/2">
                    <!-- Space for ONLY ONE image as requested -->
                    <img id="work-image" class="w-full rounded-xl object-cover aspect-video shadow-sm"
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuBuB4X2gmQwbNQvwEB8G9W1Jlv7fSRGswTN1NE_gGGuoJ1W-TnTOOuoHNU-WBcyw5QzmhOCZ77ivhK6QOGdYeRwSZSuTf-sYBQDw27V0Zc9WXBmpJwdGLKA_m_9Fq6vKLUYeqhUEF9TpVmZoSf3uUkjanTqT9H7VmwkeaQkwamP5J11pWJ2dTRy27CuSUBnNSzfOYElZ3WKfpsWUCZo4aqVtUlv5Nw7zoLQo0i_4gzUKvKXWjEi_KLXZ2_YJ9wT4rXBeWV1B-mSbgk"
                        alt="Completed Work" />
                </div>
                <div class="md:w-1/2 py-2">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3 uppercase">Corporator
                        Notes</p>
                    <p id="work-notes" class="text-sm text-gray-600 leading-relaxed">
                        ---
                    </p>
                </div>
            </div>
        </div>

        <!-- ACTION BUTTONS -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <button onclick="requestRework()"
                class="h-16 bg-[#8B312E] hover:bg-[#762927] text-white font-extrabold rounded-xl transition-all flex items-center justify-center gap-3 shadow-lg shadow-red-100 uppercase tracking-wider">
                <span class="material-symbols-outlined">restart_alt</span>
                Request Rework
            </button>
            <button onclick="approveWork()"
                class="h-16 bg-primary hover:opacity-90 text-white font-extrabold rounded-xl transition-all flex items-center justify-center gap-3 shadow-lg shadow-green-100 uppercase tracking-wider">
                <span class="material-symbols-outlined">check_circle</span>
                Approve & Resolve
            </button>
        </div>

    </main>

    <footer class="p-6 text-center text-xs text-gray-400 mt-auto border-t border-gray-100">
        <p>CivicFlow Review Unit · Admin Portal v2.4</p>
    </footer>

    <script>
        function loadReviewData() {
            const urlParams = new URLSearchParams(window.location.search);
            const complaintId = urlParams.get('id');

            if (complaintId) {
                fetch(`engine/get_status.php?id=${encodeURIComponent(complaintId)}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.status_code === 'success') {
                            document.getElementById('review-id').textContent = data.complaint_id;
                            document.getElementById('review-category').textContent = data.category;
                            document.getElementById('review-location').textContent = data.location.split(',').pop().trim() || "Area";
                            document.getElementById('review-landmark').textContent = data.landmark || "N/A";
                            document.getElementById('orig-description').textContent = '"' + data.description + '"';

                            if (data.proof_image) {
                                document.getElementById('orig-image').src = data.proof_image;
                            }

                            // Display Corporator Work
                            if (data.work_image) {
                                document.getElementById('work-image').src = data.work_image;
                            }
                            if (data.work_notes) {
                                document.getElementById('work-notes').textContent = data.work_notes;
                            }
                        }
                    });
            } else {
                window.location.href = 'admin.php';
            }
        }

        function requestRework() {
            alert("Rework request sent to corporator.");
            window.location.href = 'admin.php';
        }

        function approveWork() {
            const urlParams = new URLSearchParams(window.location.search);
            const complaintId = urlParams.get('id');

            const formData = new FormData();
            formData.append('complaint_id', complaintId);

            fetch('engine/approve_work.php', {
                method: 'POST',
                body: formData
            })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert(data.message);
                        window.location.href = 'admin.php';
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(err => console.error('Error approving work:', err));
        }

        window.onload = loadReviewData;
    </script>

</body>

</html>
