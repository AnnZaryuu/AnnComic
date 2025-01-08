<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Register User</title>
</head>
<body>
<!-- component -->
<div class="bg-gray-100 flex justify-center items-center h-screen">
    <!-- Left: Image -->
    <div class="w-1/2 h-screen hidden lg:block">
        <img src="/Assets/Rectangle 80.png" alt="Placeholder Image" class="object-cover w-full h-full">
    </div>
    <!-- Right: Registration Form -->
    <div class="lg:p-36 md:p-52 sm:20 p-8 w-full lg:w-1/2">
        <h1 class="text-2xl font-semibold mb-4">Register</h1>
        <?php if (isset($error)): ?>
            <p class="text-red-500 mb-4"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="index.php?modul=register" method="POST">
            <!-- Name Input -->
            <div class="mb-4">
                <label for="name" class="block text-gray-600">Name</label>
                <input type="text" id="name" name="name" class="w-full py-3 pl-4 pr-10 text-gray-700 bg-white border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500" autocomplete="off">
            </div>
            <!-- Email Input -->
            <div class="mb-4">
                <label for="email" class="block text-gray-600">Email</label>
                <input type="email" id="email" name="email" class="w-full py-3 pl-4 pr-10 text-gray-700 bg-white border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500" autocomplete="off">
            </div>
            <!-- Password Input -->
            <div class="mb-4">
                <label for="password" class="block text-gray-600">Password</label>
                <input type="password" id="password" name="password" class="w-full py-3 pl-4 pr-10 text-gray-700 bg-white border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500" autocomplete="off">
            </div>
            <!-- Register Button -->
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-full py-2 px-4 w-full">Register</button>
        </form>
        <!-- Already have an account? Link -->
        <div class="mt-6 text-blue-500 text-center">
            <a href="uLogin.php" class="hover:underline">Already have an account? Login here</a>
        </div>
    </div>
</div>
<?php include 'includes/footer/uFooter.php'; ?>

</body>
</html>
