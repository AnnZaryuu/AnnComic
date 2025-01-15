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
    <?php include __DIR__ . '/includes/navbar/uNavbar.php'; ?>
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
                            <button onclick="window.location.href='index.php?modul=readComic&id=<?php echo htmlspecialchars($komik->id ?? ''); ?>&chapter=1'" class="bg-blue-600 px-6 py-2 rounded-lg hover:bg-blue-700">READ</button>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Categories -->
             <?php include 'includes/ListGenre/listgenre.php'; ?>

            <!-- Popular Section -->
            <section>
            <h3 class="text-xl font-bold text-white my-6">Popular this month</h3>
                <div class="grid grid-cols-5 gap-4">
                    <!-- Card -->
                    <?php
                        require_once __DIR__ . '/../models/komik_model.php';
                        $komikModel = new KomikModel();
                        $selectedGenre = $_GET['genre'] ?? null;
                        $komikList = $selectedGenre ? $komikModel->getKomikByGenre($selectedGenre) : $komikModel->getKomikList();
                        foreach ($komikList as $komik) {
                            echo '<div class="bg-white shadow-lg rounded-lg overflow-hidden">';
                            echo '<a href="index.php?modul=detailKomik&id=' . $komik->id . '">';
                            echo '<img src="' . $komik->image . '" alt="' . $komik->judul . '" class="w-full h-48 object-cover">'; // Update the image path
                            echo '<div class="p-4">';
                            echo '<h4 class="font-bold text-lg">' . $komik->judul . '</h4>';
                            echo '<p class="text-gray-600">';
                            if (is_array($komik->chapters)) {
                                $totalChapters = count($komik->chapters);
                                if ($totalChapters > 1) {
                                    echo '' . $komik->chapters[0]->title . '<br>';
                                    echo '' . $komik->chapters[$totalChapters - 1]->title . '<br>';
                                } else {
                                    echo 'Chapter 1: ' . $komik->chapters[0]->title . '<br>';
                                }
                            } else {
                                echo $komik->chapters->title;
                            }
                            echo '</p>';
                            echo '<p class="text-yellow-500 font-semibold">' . $komik->rating . '</p>';
                            echo '</div>';
                            echo '</a>';
                            echo '</div>';
                        }
                        ?>
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
