<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Read Comic</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-b from-gray-900 via-gray-800 to-gray-900 text-white min-h-screen">
    <!-- Navbar -->
    <?php include 'includes/navbar/uNavbar.php'; ?>

    <div class="container mx-auto py-10 px-5">
        <div class="bg-gray-800 rounded-lg shadow-lg p-8">
            <!-- Header -->
            <h1 class="text-4xl font-extrabold text-center text-teal-400 mb-6">Read Comic</h1>
            <p class="text-center text-gray-400 mb-8">Enjoy reading your favorite manga in a sleek and modern viewer.</p>

            <!-- Comic Viewer Section -->
            <div class="relative border-4 border-teal-500 rounded-lg shadow-xl overflow-hidden">
                <iframe 
                    src="../Assets/Comic/Manga/VINLAND SAGA/Vinl.Sag VOLUME (1).pdf#toolbar=0" 
                    class="w-full h-[80vh]" 
                    frameborder="0">
                </iframe>
            </div>

            <!-- Download Button -->
            <div class="mt-8 flex justify-center">
                <a 
                    href="../Assets/Comic/Manga/VINLAND SAGA/Vinl.Sag VOLUME (1).pdf" 
                    download 
                    class="bg-teal-500 hover:bg-teal-600 text-white font-bold py-2 px-6 rounded-lg shadow-md hover:shadow-lg transition">
                    Download PDF
                </a>
            </div>
        </div>

        <!-- Footer -->
        <?php include 'includes/footer/uFooter.php'; ?>
        
    </div>
</body>
</html>
