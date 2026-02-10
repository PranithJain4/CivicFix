<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CivicConnect – Sign Up</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined&display=swap" rel="stylesheet">

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

<body class="min-h-screen bg-gray-50 flex flex-col">

  <!-- HEADER -->
  <header class="border-b bg-white px-6 py-3 flex items-center gap-3">
    <span class="material-symbols-outlined text-primary mr-2">admin_panel_settings</span>
    <h1 class="text-lg font-bold">CivicFix</h1>
  </header>

  <!-- MAIN CONTENT -->
  <main class="flex-1 flex items-center justify-center p-4">

    <!-- SIGNUP CARD -->
    <div class="w-full max-w-md bg-white border rounded-xl shadow-md p-8">

      <div class="text-center mb-8">
        <h2 class="text-2xl font-bold">Create your account</h2>
        <p class="text-gray-500 mt-1">
          Join your community in making the city better
        </p>
      </div>

      <!-- FORM -->
      <form onsubmit="handleSignup(event)" class="space-y-5">

        <!-- FULL NAME -->
        <div>
          <label class="block text-sm font-medium mb-1">Full Name</label>
          <input id="name" type="text" required placeholder="Enter your name"
            class="w-full h-12 border rounded-lg px-4 focus:ring-2 focus:ring-primary focus:outline-none">
        </div>

        <!-- EMAIL -->
        <div>
          <label class="block text-sm font-medium mb-1">Email</label>
          <input id="email" type="email" required placeholder="Enter your email-id"
            class="w-full h-12 border rounded-lg px-4 focus:ring-2 focus:ring-primary focus:outline-none">
        </div>

        <!-- PASSWORD -->
        <div>
          <label class="block text-sm font-medium mb-1">Password</label>
          <div class="relative">
            <input id="password" type="password" required placeholder="••••••••"
              class="w-full h-12 border rounded-lg px-4 pr-12 focus:ring-2 focus:ring-primary focus:outline-none">

            <button type="button" onclick="togglePassword()"
              class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500">
              <span id="eye" class="material-symbols-outlined">visibility</span>
            </button>
          </div>
        </div>

        <!-- SIGNUP BUTTON -->
        <button type="submit"
          class="w-full h-12 bg-primary hover:opacity-90 text-white font-bold rounded-lg transition">
          Sign Up
        </button>

        <!-- LOGIN LINK -->
        <p class="text-center text-sm text-gray-600">
          Already a member?
          <a href="login.php" class="text-primary font-bold hover:underline">
            Back to Login
          </a>
        </p>

        <!-- TERMS -->
        <p class="text-xs text-center text-gray-500 mt-4">
          By signing up, you agree to our
          <a href="#" class="underline">Terms</a> &
          <a href="#" class="underline">Privacy Policy</a>
        </p>

      </form>
    </div>
  </main>

  <!-- JS -->
  <script>

    function togglePassword() {
      const pwd = document.getElementById("password");
      const eye = document.getElementById("eye");

      if (pwd.type === "password") {
        pwd.type = "text";
        eye.textContent = "visibility_off";
      } else {
        pwd.type = "password";
        eye.textContent = "visibility";
      }
    }

    function handleSignup(e) {
      e.preventDefault();

      const formData = new FormData();
      formData.append('username', document.getElementById("name").value);
      formData.append('email', document.getElementById("email").value);
      formData.append('password', document.getElementById("password").value);

      fetch('engine/auth_signup.php', {
        method: 'POST',
        body: formData
      })
        .then(res => res.json())
        .then(data => {
          if (data.status === 'success') {
            alert(data.message);
            window.location.href = "login.php";
          } else {
            alert(data.message);
          }
        })
        .catch(err => {
          console.error('Error:', err);
          alert("An error occurred. Please try again.");
        });
    }
  </script>

</body>

</html>
