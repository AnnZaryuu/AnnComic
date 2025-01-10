<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Login User</title>
</head>
<body>
<!-- component -->
<div class="bg-gray-100 flex justify-center items-center h-screen">
    <!-- Left: Image -->
<div class="w-1/2 h-screen hidden lg:block">
  <img src="/Assets/Rectangle 80.png" alt="Placeholder Image" class="object-cover w-full h-full">
</div>
<!-- Right: Login Form -->
<div class="lg:p-36 md:p-52 sm:20 p-8 w-full lg:w-1/2">
  <h1 class="text-2xl font-semibold mb-4">Welcome Back XD</h1>
  <?php if (isset($error)): ?>
    <p class="text-red-500 mb-4"><?php echo $error; ?></p>
  <?php endif; ?>
  <form action="index.php?modul=login" method="POST">
    <!-- Email Input -->
    <div class="mb-4">
      <label for="Email" class="block text-gray-600">Email</label>
      <input type="text" id="Email" name="Email" class="w-full py-3 pl-4 pr-10 text-gray-700 bg-white border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500" autocomplete="off">
    </div>
    <!-- Password Input -->
    <div class="mb-4">
      <label for="password" class="block text-gray-600">Password</label>
      <div class="relative">
        <input type="password" id="password" name="password" class="w-full py-3 pl-4 pr-10 text-gray-700 bg-white border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500" autocomplete="off">
        <button type="button" id="togglePassword" class="absolute inset-y-0 right-4 text-gray-500 hover:text-gray-700">
          Show
        </button>
      </div>
    </div>
    <!-- Remember Me Checkbox -->
    <div class="mb-4 flex items-center">
      <input type="checkbox" id="remember" name="remember" class="text-blue-500 rounded-full">
      <label for="remember" class="text-gray-600 ml-2">Remember Me</label>
    </div>
    <!-- Forgot Password Link -->
    <div class="mb-6 text-blue-500">
      <a href="#" class="hover:underline">Forgot Password?</a>
    </div>
    <!-- Login Button -->
    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-full py-2 px-4 w-full">Login</button>
  </form>
</div>
</div>
<!-- Footer -->
<?php include 'includes/footer/uFooter.php'; ?>

<script>
  const togglePassword = document.getElementById('togglePassword');
  const passwordInput = document.getElementById('password');

  togglePassword.addEventListener('click', function () {
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);
    this.textContent = type === 'password' ? 'Show' : 'Hide';
  });
</script>
</body>
</html>
