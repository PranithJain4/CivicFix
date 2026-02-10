<!DOCTYPE html>
<html class="light" lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Clean & Green City - Report Civic Issues</title>

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;700;900&display=swap"
    rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
    rel="stylesheet" />

  <script src="https://cdn.tailwindcss.com"></script>

  <script>
    tailwind.config = {
      darkMode: "class",
      theme: {
        extend: {
          colors: {
            primary: "#45B25C",
          },
          fontFamily: {
            sans: ["Public Sans", "sans-serif"],
          },
        },
      },
    };
  </script>
</head>

<body
  class="font-sans bg-[#F8FAFC] dark:bg-[#0F172A] text-gray-900 dark:text-white antialiased transition-colors duration-200">

  <div class="relative flex min-h-screen w-full flex-col overflow-x-hidden">

    <!-- HEADER -->
    <header
      class="sticky top-0 z-50 w-full border-b border-gray-200 dark:border-white/10 bg-[#F8FAFC]/90 dark:bg-[#0F172A]/90 backdrop-blur-md">
      <div class="flex h-16 items-center justify-between px-4 md:px-10 max-w-7xl mx-auto">
        <div class="flex items-center gap-4">
          <span class="material-symbols-outlined text-primary text-3xl">
            admin_panel_settings
          </span>
          <h2 class="text-lg font-bold">CivicFix</h2>
        </div>
      </div>
    </header>


    <main class="flex-1">

      <!-- HERO -->
      <section class="px-4 py-12 md:py-20 lg:py-28 max-w-7xl mx-auto">
        <div class="@container">
          <div class="flex flex-col-reverse gap-8 lg:flex-row lg:items-center">

            <div class="flex flex-1 flex-col gap-6 lg:max-w-xl">
              <span
                class="w-fit rounded-full bg-primary/10 px-3 py-1 text-xs font-bold uppercase tracking-wider text-primary">
                Official Municipal Portal
              </span>

              <h1 class="text-4xl md:text-5xl lg:text-6xl font-black">
                Clean & Green <br />
                <span class="text-primary">City Initiative</span>
              </h1>

              <p class="text-lg text-gray-600 dark:text-gray-300">
                Report civic issues in real time and track resolution transparently.
              </p>

              <div class="flex flex-wrap gap-4">
                <button onclick="goComplaint()"
                  class="h-14 px-8 rounded-xl bg-primary text-white font-black text-lg shadow-xl shadow-green-100 dark:shadow-none hover:opacity-90 transition-all hover:scale-[1.02] active:scale-[0.98]">
                  Report Issue
                </button>

                <button onclick="goStatus()"
                  class="h-14 px-8 rounded-xl border-2 border-primary text-primary font-bold text-lg hover:bg-primary/5 transition-all">
                  Track Status
                </button>
              </div>

              <div class="flex items-center gap-4 mt-2">
                <button onclick="goLogin()" class="text-sm font-bold text-gray-500 hover:text-primary">Login</button>
                <div class="w-1.5 h-1.5 rounded-full bg-gray-300"></div>
                <button onclick="goSignup()" class="text-sm font-bold text-gray-500 hover:text-primary">Create
                  Account</button>
              </div>
            </div>

            <div class="flex-1">
              <div class="aspect-video rounded-2xl bg-cover bg-center shadow-2xl"
                style="background-image:url('https://lh3.googleusercontent.com/aida-public/AB6AXuCGq6lt50B0pNhRTl1CttOuqdFgZHt8GUgl-IyGbzhhOhTFJUm379arLaS9-FIg0tmP67-y8wuQK3vnfqP09bpkpq_AZAifPHPCB2PktM9ilo9QXjCsIF8GiJar7r-foqM5_f6bikUVd-QGozXM0PS9kGspT7y1clRNNpOiBbE3_t4slaVXh5yVzz_WbXn90n6fzTrrp5k2oqX-_3lSzsR_kevQmt5S6C8JPC7F2HpnV4i6576k2NM_3hUBsZKNDxA_8BhLklnJ_IQ');">
              </div>
            </div>

          </div>
        </div>
      </section>

      <!-- HOW IT WORKS -->
      <section class="py-16 md:py-24 max-w-7xl mx-auto px-4">
        <h2 class="text-3xl md:text-4xl font-black mb-10">How It Works</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div class="rounded-2xl border p-8 bg-white dark:bg-white/5">
            <span class="material-symbols-outlined text-primary text-3xl">add_a_photo</span>
            <h3 class="font-bold text-xl mt-3">Report Issue</h3>
            <p class="text-gray-600 dark:text-gray-400">Upload image and submit complaint.</p>
          </div>

          <div class="rounded-2xl border p-8 bg-white dark:bg-white/5">
            <span class="material-symbols-outlined text-primary text-3xl">query_stats</span>
            <h3 class="font-bold text-xl mt-3">Track Status</h3>
            <p class="text-gray-600 dark:text-gray-400">Track progress transparently.</p>
          </div>

          <div class="rounded-2xl border p-8 bg-white dark:bg-white/5">
            <span class="material-symbols-outlined text-primary text-3xl">verified</span>
            <h3 class="font-bold text-xl mt-3">Issue Resolved</h3>
            <p class="text-gray-600 dark:text-gray-400">Get confirmation after resolution.</p>
          </div>
        </div>
      </section>
  </div>

  <script>
    function goSignup() { location.href = "signup.php"; }
    function goLogin() { location.href = "login.php"; }
    function goComplaint() { location.href = "complaint.php"; }
    function goStatus() { location.href = "status.php"; }
  </script>

</body>

</html>
