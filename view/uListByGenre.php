<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>List Komik by Genre</title>
    <style>
        body {
            background-image: url('../Assets/Wallpaper_background.jpg');
            background-size: cover;
            background-attachment: fixed;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <?php include 'includes/navbar/uNavbar.php'; ?>
    
    <div class="bg-gray-900 bg-opacity-75 min-h-screen py-8">
        <!-- Card List -->
        <div class="max-w-6xl mx-auto space-y-8">
            <?php
            require_once __DIR__.'/../models/komik_model.php';
            $komikModel = new KomikModel();
            $selectedGenre = $_GET['genre'] ?? null;

            if ($selectedGenre) {
                $comics = $komikModel->getKomikByGenre($selectedGenre);
            } else {
                $comics = $komikModel->getKomikList();
            }

            foreach ($comics as $comic) {
                echo '
                <a href="index.php?modul=detailKomik&id=' . $comic->id . '">
                    <div class="flex bg-blue-600 rounded-lg overflow-hidden shadow-md mb-4">
                        <!-- Thumbnail -->
                        <img src="' . $comic->image . '" alt="Thumbnail" class="w-24 h-auto">
                        <!-- Content -->
                        <div class="flex flex-col justify-between p-4 text-white flex-1">
                            <div class="flex justify-between">
                                <div>
                                    <h2 class="text-lg font-bold">' . $comic->judul . '</h2>
                                    <p class="text-sm">' . $comic->penulis . '</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-bold bg-green-400 text-blue-600 px-2 py-1 rounded">Price: ' . $comic->harga . '</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">';
                                foreach ($comic->genre as $genre) {
                                    echo '<span class="bg-white text-blue-600 text-xs font-bold px-2 py-1 rounded">' . $genre . '</span>';
                                }
                                echo '
                                <span class="text-xs">Chapter ' . count($comic->chapters) . '</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span>Updated recently</span>
                                <span class="font-bold">⭐ ' . $comic->rating . '</span>
                            </div>
                        </div>
                    </div>
                </a>';
            }
            ?>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'includes/footer/uFooter.php'; ?>
</body>
</html>
