<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Home User</title>
</head>
<body class="bg-black font-sans">
    <!-- Navbar -->
    <?php include 'includes/navbar/uNavbar.php'; ?>
    <!-- Sidebar & Content -->
    <div class="flex">
        <!-- Main Content -->
        <main class="flex-1 p-6">
            <!-- Featured Section -->
            <section class="mb-6">
                <div class="relative bg-cover bg-center rounded-lg overflow-hidden" style="background-image: url('../Assets/Rectangle 14.png'); height: 300px;">
                    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center text-white">
                        <div class="ml-10 text-left">
                            <h2 class="text-4xl font-bold mb-4">One Piece</h2>
                            <p class="max-w-md mb-4">"Kid so focused on building a bird out of scrap metal, he doesn't realize his head got turned into a bird's nest"</p>
                            <button onclick="window.location.href='index.php?modul=readComic'" class="bg-blue-600 px-6 py-2 rounded-lg hover:bg-blue-700">READ</button>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Categories -->
             <?php include 'includes/ListGenre/listgenre.php'; ?>

            <!-- Popular Section -->
            <section>
                <h3 class="text-xl font-bold mb-4">Popular this month</h3>
                <div class="grid grid-cols-5 gap-4">
                    <!-- Card -->
                    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                        <img src="../Assets/Poster book/One Piace.png" alt="One Piece" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h4 class="font-bold text-lg">One Piece</h4>
                            <p class="text-gray-600">Chapter 1012</p>
                            <p class="text-yellow-500 font-semibold">9.36</p>
                        </div>
                    </div>
                    <!-- Repeat Card for other items -->
                </div>
            </section>

            <!-- Spotify Playlist Section -->
            <section class="mt-8">
                <h3 class="text-xl font-bold mb-4 text-white">Listen While You Read</h3>
                <iframe style="border-radius:12px" src="https://open.spotify.com/embed/playlist/3sFVKF07pPynB0XBLfCMkP?utm_source=generator" width="100%" height="352" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>
            </section>
        </main>
    </div>
    <!-- Fotter  -->
<?php include 'includes/footer/uFooter.php'; ?>
</body>
</html>
