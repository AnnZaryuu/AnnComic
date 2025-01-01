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
            <div class="relative bg-cover bg-center rounded-lg overflow-hidden" style="background-image: url('../Assets/Poster landscape/vindland saga landscape.png'); height: 300px;">
                <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center text-white p-8">
                    <!-- Kontainer Utama -->
                    <div class="flex space-x-8">
                        <!-- Komik Cover -->
                        <div class="flex-shrink-0">
                            <img src="../Assets/Poster book/vindland saga poster 1.png" alt="Vinland Saga" class="w-40 h-auto rounded-lg shadow-lg">
                        </div>
                        <!-- Komik Detail -->
                        <div>
                            <h1 class="text-4xl font-bold">Vinland Saga</h1>
                            <div class="flex items-center space-x-4 mt-2">
                                <img src="../Assets/Author/vindland saga author.png" alt="Yukimura Makoto" class="w-12 h-12 rounded-full">
                                <div>
                                    <p class="font-semibold">Yukimura Makoto</p>
                                    <p class="text-gray-400">Serialization: Afternoon</p>
                                </div>
                            </div>
                            <div class="mt-4">
                                <span class="text-yellow-500">★★★★★</span>
                                <span class="text-gray-400">(5 Reviews)</span>
                            </div>
                            <div class="flex space-x-4 mt-4">
                                <button class="bg-blue-500 px-4 py-2 rounded-lg shadow hover:bg-blue-600">$10.7</button>
                                <button class="bg-gray-600 px-4 py-2 rounded-lg shadow hover:bg-gray-700">Free Sample</button>
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
            <h1 class="text-2xl font-extrabold font-bold text-white">
                About
            </h1>
            <!-- Sinopsis -->
            <p class="text-gray-300 mt-4">
                Thorfinn tumbuh mendengarkan cerita tentang Vinland, tempat yang hangat dan subur. Sekarang, hidupnya sebagai tentara bayaran terjebak dalam perang antara Inggris dan Denmark. Meski ayahnya pernah berkata bahwa tidak ada musuh, Thorfinn tahu kenyataannya berbeda. Di tengah kekacauan perang, Thorfinn harus membalas dendam pada Askeladd, yang membunuh ayahnya. Satu-satunya "surga" bagi para Viking tampaknya adalah era perang dan kematian yang berkepanjangan.
            </p>
        </div>
        <div>

            <!-- Judul Chapter -->
    <h1 class="text-2xl font-extrabold font-bold text-white">
        You May Also Like
    </h1>
    <div class="flex  gap-4 mt-5 overflow-x-scroll no-scrollbar" style="width: 800px;">
        <!-- Related Komik -->
        <?php
        $relatedKomik = [
            ['title' => 'Dr. Stone', 'image' => '../Assets/Poster img/dr_ stone poster.jpeg'],
            ['title' => 'Made in Abyss', 'image' => '../Assets/Poster img/Made in Abbys.jpeg'],
            ['title' => 'Frieren: Beyond Journey\'s End ', 'image' => '../Assets/Poster img/Frieren.jpeg'],
            ['title' => 'To Your Eternity', 'image' => '../Assets/Poster img/to your eternity.jpeg'],
            ['title' => 'Attack on Titan', 'image' => '../Assets/Poster img/Attack on Titan.jpeg'],
        ];

        foreach ($relatedKomik as $komik) {
            echo "
            <div class='bg-gray-800 p-4 rounded-lg shadow-lg flex-shrink-0 w-48'>
                <img src='{$komik['image']}' alt='{$komik['title']}' class='rounded-lg w-full h-60 object-cover'>
                <h3 class='mt-2 text-center font-semibold text-white'>{$komik['title']}</h3>
            </div>
            ";
        }
        ?>
    </div>
</div>
        
</body>
</html>
