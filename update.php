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
    <title>CivicFix - Update Work</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700;800;900&display=swap"
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
            background-color: #f9fafb;
        }

        .drop-zone:hover {
            border-color: #45B25C;
            background-color: rgba(69, 178, 92, 0.05);
        }
    </style>
</head>

<body class="min-h-screen text-[#333D47] flex flex-col">

    <!-- HEADER -->
    <header class="w-full border-b border-gray-200 bg-white sticky top-0 z-50">
        <div class="px-6 h-16 flex items-center">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-accent-green text-3xl">admin_panel_settings</span>
                <span class="text-xl font-black tracking-tight text-gray-900">CivicFix</span>
            </div>
        </div>
    </header>

    <!-- MAIN -->
    <main class="max-w-4xl mx-auto px-4 py-10 sm:px-6 lg:px-8 w-full flex-1">
        <!-- TITLE -->
        <div class="mb-10">
            <h1 class="text-3xl font-black tracking-tight text-[#0c1b1d]">Submit Work Completion</h1>
            <p class="mt-1 text-gray-500 font-medium">Upload proof and submit completed work.</p>
        </div>

        <!-- COMPLAINT SUMMARY CARD -->
        <section class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-8">
            <div class="p-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-8">
                    <div>
                        <dt class="text-[10px] uppercase font-black text-gray-400 tracking-widest mb-1.5">Complaint ID
                        </dt>
                        <dd id="disp-id" class="text-xs font-bold text-gray-900 tracking-tight">#CMP-8829</dd>
                    </div>
                    <div>
                        <dt class="text-[10px] uppercase font-black text-gray-400 tracking-widest mb-1.5">Category</dt>
                        <dd id="disp-category" class="text-xs font-bold text-gray-900 tracking-tight">Pothole Repair
                        </dd>
                    </div>
                    <div>
                        <dt class="text-[10px] uppercase font-black text-gray-400 tracking-widest mb-1.5">Location</dt>
                        <dd id="disp-location" class="text-xs font-bold text-gray-900 tracking-tight">North Ward (Zone
                            4)</dd>
                    </div>
                    <div>
                        <dt class="text-[10px] uppercase font-black text-gray-400 tracking-widest mb-1.5">Landmark</dt>
                        <dd id="disp-landmark" class="text-xs font-bold text-gray-900 tracking-tight">123 Maple St, Near
                            Public Library</dd>
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-50">
                    <dt class="text-[10px] uppercase font-black text-gray-400 tracking-widest mb-3">Initial Citizen
                        Report</dt>
                    <div class="bg-gray-50/80 rounded-xl p-5 border border-gray-100">
                        <p id="disp-description" class="text-sm text-gray-600 leading-relaxed italic font-medium">
                            "There is a deep pothole in the middle of the lane right in front of the library entrance.
                            It's becoming dangerous for cyclists and small cars, especially when it rains and fills with
                            water."
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ORIGINAL PHOTO SECTION -->
        <section class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-8">
            <div class="p-8">
                <h2 class="text-xs font-black text-gray-400 mb-5 uppercase tracking-widest">Original Complaint Photo
                </h2>
                <div class="relative rounded-2xl overflow-hidden bg-gray-100 aspect-video shadow-inner">
                    <img id="disp-image" alt="Original complaint image" class="w-full h-full object-cover"
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuC73e18BtrPnKDYB6aO8-mtjmoxFMZn7c3MDeCg0V7pRUMY5VDiHR3SpR7g8obH_eeZ5iGpxJVhvaKF8K97sNa3Ksig_dLp97C18rV_hpssE-TSvRR0sI-ImDRdOi-MyG65hr67CKP3cCji5pwsJ5N1rPbz245TwV96WFLYxdJXXmwGUiyOH7IYM0wc2sZ1ieJeR1HiF_y-E6hkOlUXTaEQBEofEi9b4okSFJlKjXOLc-i1uHP2JiqC3mdyRmp7-MohoPJ4ct2pHKQ" />
                    <div class="absolute bottom-5 left-5">
                        <span
                            class="bg-black/60 backdrop-blur-md text-white px-4 py-2 rounded-full text-[10px] font-extrabold uppercase tracking-widest flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">person</span> CITIZEN UPLOAD
                        </span>
                    </div>
                </div>
            </div>
        </section>

        <!-- SUBMISSION FORM -->
        <form class="space-y-8" onsubmit="handleSubmit(event)">
            <!-- PHOTO UPLOAD -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-8">
                    <label class="block text-xs font-black text-gray-400 mb-5 uppercase tracking-widest">Upload
                        Completion Photo</label>
                    <div
                        class="drop-zone relative group cursor-pointer border-2 border-dashed border-gray-200 rounded-2xl p-16 transition-all flex flex-col items-center justify-center bg-gray-50/50">
                        <input accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer" type="file"
                            required />
                        <div
                            class="bg-white p-4 rounded-full shadow-sm mb-4 group-hover:scale-110 transition-transform">
                            <span
                                class="material-symbols-outlined text-4xl text-primary group-hover:text-primary-dark">add_a_photo</span>
                        </div>
                        <p class="text-gray-900 font-extrabold text-sm mb-1">Click to upload photo</p>
                        <p class="text-gray-400 text-xs font-medium">Capture clear proof of completed work.</p>
                    </div>
                </div>
            </div>

            <!-- DESCRIPTION -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
                <label class="block text-xs font-black text-gray-400 mb-4 uppercase tracking-widest"
                    for="description">Work Description</label>
                <textarea
                    class="w-full rounded-xl border-gray-200 bg-gray-50/50 focus:border-primary focus:ring focus:ring-primary/10 transition-all placeholder:text-gray-400 font-medium text-sm p-4"
                    id="description"
                    placeholder="Briefly describe what was done (e.g. materials used, finishing details)..." rows="5"
                    required></textarea>
            </div>

            <!-- SUBMIT BUTTON -->
            <div class="space-y-6">
                <button
                    class="w-full h-16 bg-primary hover:opacity-90 text-white text-lg font-black tracking-wider rounded-2xl shadow-lg shadow-green-100 transition-all flex items-center justify-center gap-3 uppercase"
                    type="submit">
                    <span class="material-symbols-outlined">check_circle</span>
                    MARK WORK AS COMPLETED
                </button>
                <div
                    class="flex items-center justify-center gap-2 text-gray-400 font-bold uppercase tracking-widest text-[10px]">
                    <span class="material-symbols-outlined text-sm">shield_with_heart</span>
                    <span>Admin Review Required after submission</span>
                </div>
            </div>
        </form>
    </main>

    <!-- FOOTER -->
    <footer class="max-w-4xl mx-auto px-4 py-10 sm:px-6 lg:px-8 border-t border-gray-100 mt-12 w-full">
        <div class="flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-2 text-gray-400">
                <span class="material-symbols-outlined text-lg">admin_panel_settings</span>
                <span class="text-[10px] font-black uppercase tracking-widest">CivicFix Portal · 2026</span>
            </div>
            <div class="flex gap-8 text-[10px] font-black uppercase tracking-widest text-gray-400">
                <a class="hover:text-primary transition-colors" href="#">Support</a>
                <a class="hover:text-primary transition-colors" href="#">Legal</a>
                <a class="hover:text-primary transition-colors" href="#">Guidelines</a>
            </div>
        </div>
    </footer>

    <script>
        function loadData() {
            const urlParams = new URLSearchParams(window.location.search);
            const complaintId = urlParams.get('id');

            if (complaintId) {
                fetch(`engine/get_status.php?id=${encodeURIComponent(complaintId)}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.status_code === 'success') {
                            document.getElementById('disp-id').textContent = '#' + data.complaint_id;
                            document.getElementById('disp-category').textContent = data.category;
                            document.getElementById('disp-location').textContent = data.location.split(',').pop().trim() || "Area";
                            document.getElementById('disp-landmark').textContent = data.landmark || "N/A";
                            document.getElementById('disp-description').textContent = '"' + data.description + '"';
                            if (data.proof_image) {
                                document.getElementById('disp-image').src = data.proof_image;
                            }
                        }
                    });
            } else {
                window.location.href = 'corpdash.php';
            }
        }

        function handleSubmit(e) {
            e.preventDefault();

            const urlParams = new URLSearchParams(window.location.search);
            const complaintId = urlParams.get('id');
            const notes = document.getElementById('description').value;

            const formData = new FormData();
            formData.append('complaint_id', complaintId);
            formData.append('notes', notes);

            const fileInput = document.querySelector('input[type="file"]');
            if (fileInput.files.length > 0) {
                formData.append('image', fileInput.files[0]);
            }

            fetch('engine/resolve_complaint.php', {
                method: 'POST',
                body: formData
            })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert(data.message);
                        window.location.href = 'corpdash.php';
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(err => console.error('Error submitting work:', err));
        }

        window.onload = loadData;
    </script>

</body>

</html>
