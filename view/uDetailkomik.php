<?php
require_once __DIR__ . '/../models/komik_model.php';


$komikId = $_GET['id'] ?? null;
$komikModel = new KomikModel();
$komik = $komikModel->getKomikById($komikId);

if (!$komik) {
    echo "Komik not found!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Komik</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
    body {
        overflow-x: hidden;
    }
    .no-scrollbar {
        scrollbar-width: none;
        -ms-overflow-style: none;
    }
    .no-scrollbar::-webkit-scrollbar {
        display: none; /* Chrome, Safari, Edge berbasis Chromium */
    }
    </style>

</head>
<body class="bg-gray-900 text-white">

    <!-- Navbar -->
    <?php include 'includes/navbar/uNavbar.php'; ?>
    
    <div class="container mx-auto p-5">

        <!-- Background detail -->
        <section class="mb-6">
        <div class="relative bg-cover bg-center rounded-lg overflow-hidden" style="background-image: url('<?php echo $komik->background; ?>'); height: 300px;">
                <div class="absolute inset-0 bg-black bg-opacity-25 flex items-center text-white p-8">
                    <!-- Kontainer Utama -->
                    <div class="flex space-x-8">
                        <!-- Komik Cover -->
                        <div class="flex-shrink-0">
                            <img src="../Assets/<?php echo $komik->image; ?>" alt="<?php echo $komik->judul; ?>" class="w-40 h-auto rounded-lg shadow-lg">
                        </div>
                        <!-- Komik Detail -->
                        <div>
                            <h1 class="text-4xl font-bold"><?php echo $komik->judul; ?></h1>
                            <div class="flex items-center space-x-4 mt-2">
                                <img src="<?php echo $komik->author; ?>" alt="<?php echo $komik->penulis; ?>" class="w-12 h-12 rounded-full">
                                <div>
                                    <p class="font-semibold"><?php echo $komik->penulis; ?></p>
                                    <p class="text-gray-400">Serialization: <?php echo $komik->penerbit; ?></p>
                                </div>
                            </div>
                            <div class="mt-4">
                                <span class="text-yellow-500">★★★★★</span>
                                <span class="text-gray-400">(<?php echo $komik->rating; ?>)</span>
                            </div>
                            <div class="mt-2">
                                <p class="text-gray-300"><?php echo is_array($komik->genre) ? implode(', ', $komik->genre) : $komik->genre; ?></p>
                            </div>
                            <div class="flex space-x-4 mt-4">
                                <button onclick="window.location.href='index.php?modul=chapter&id=<?php echo $komik->id; ?>'" class="bg-blue-500 px-4 py-2 rounded-lg shadow hover:bg-blue-600">View Chapter</button>
                                <button onclick="window.location.href='index.php?modul=freeSample&id=<?php echo $komik->id; ?>'" class="bg-gray-600 px-4 py-2 rounded-lg shadow hover:bg-gray-700">Free Sample</button>
                                <button class="bg-gray-600 px-4 py-2 rounded-lg shadow hover:bg-gray-700">Add Bookmark</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="grid grid-cols-3 gap-5">
            <div>
                <!-- Judul About -->
                <h1 class="text-2xl font-extrabold font-bold text-white">About</h1>
                <!-- Sinopsis -->
                <p class="text-gray-300 mt-4"><?php echo $komik->sinopsis; ?></p>
            </div>
            <div>
                <!-- Judul Chapter -->
                <h1 class="text-2xl font-extrabold font-bold text-white">You May Also Like</h1>
                <div class="flex gap-4 mt-5 overflow-x-scroll no-scrollbar" style="width: 800px;">
                    <!-- Related Komik -->
                    <?php include 'includes/RelatedKomik/relatedKomik.php'; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
