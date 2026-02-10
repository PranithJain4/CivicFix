<!DOCTYPE html>
<html lang="en" class="light">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CivicResolution – Login</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;700&display=swap" rel="stylesheet" />
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

<body class="min-h-screen bg-gray-50 flex flex-col">

  <!-- HEADER -->
  <header class="border-b bg-white px-6 py-3 flex items-center gap-3">
    <span class="material-symbols-outlined text-primary mr-2">admin_panel_settings</span>
    <h1 class="text-lg font-bold">CivicFix</h1>
  </header>

  <!-- MAIN -->
  <main class="flex-1 flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-white rounded-xl shadow-md border p-8">

      <!-- TITLE -->
      <div class="text-center mb-8">
        <h2 class="text-3xl font-bold">Login</h2>
        <p class="text-gray-500 mt-2">Access the Civic Resolution Portal</p>
      </div>

      <!-- FORM -->
      <form onsubmit="handleLogin(event)" class="space-y-6">

        <!-- ROLE -->
        <div>
          <label class="block text-sm font-medium mb-1">Login as</label>
          <select id="role"
            class="w-full h-12 border rounded-lg px-4 focus:ring-2 focus:ring-primary focus:outline-none">
            <option value="citizen">Citizen</option>
            <option value="corporator">Corporator</option>
            <option value="admin">Administrator</option>
          </select>
        </div>

        <!-- EMAIL -->
        <div>
          <label class="block text-sm font-medium mb-1">Email</label>
          <input id="email" type="email" required placeholder="Enter your email-id"
            class="w-full h-12 border rounded-lg px-4 focus:ring-2 focus:ring-primary focus:outline-none" />
        </div>

        <!-- PASSWORD -->
        <div>
          <label class="block text-sm font-medium mb-1">Password</label>
          <div class="relative">
            <input id="password" type="password" required placeholder="••••••••"
              class="w-full h-12 border rounded-lg px-4 pr-12 focus:ring-2 focus:ring-primary focus:outline-none" />
            <button type="button" onclick="togglePassword()"
              class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500">
              <span id="eye" class="material-symbols-outlined">visibility</span>
            </button>
          </div>
        </div>

        <!-- LOGIN BUTTON -->
        <button type="submit"
          class="w-full h-12 bg-primary hover:opacity-90 text-white font-bold rounded-lg flex items-center justify-center gap-2">
          Login
          <span class="material-symbols-outlined">login</span>
        </button>

        <!-- SIGNUP -->
        <p class="text-center text-sm text-gray-600">
          New user?
          <a href="signup.php" class="text-primary font-bold hover:underline">Sign Up</a>
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

    function handleLogin(e) {
      e.preventDefault();

      const formData = new FormData();
      formData.append('email', document.getElementById("email").value);
      formData.append('password', document.getElementById("password").value);

      fetch('engine/auth_login.php', {
        method: 'POST',
        body: formData
      })
        .then(res => res.json())
        .then(data => {
          if (data.status === 'success') {
            // Redirect based on the role returned by the engine
            if (data.role === 'admin') {
              window.location.href = "admin.php";
            } else if (data.role === 'corporator') {
              window.location.href = "corpdash.php";
            } else {
              window.location.href = "complaint.php";
            }
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
