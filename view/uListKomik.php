<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>List Komik</title>
</head>
<body>
        <!-- Navbar -->
        <?php include 'includes/navbar/uNavbar.php'; ?>
        
<div class="bg-gray-900 min-h-screen py-8">
  <!-- Card List -->
  <div class="max-w-6xl mx-auto space-y-4">
    <!-- Card Item -->
    <div class="flex bg-blue-600 rounded-lg overflow-hidden shadow-md">
      <!-- Thumbnail -->
      <img src="/Assets/Poster book/One Piace.png" alt="Thumbnail" class="w-24 h-auto">
      <!-- Content -->
      <div class="flex flex-col justify-between p-4 text-white flex-1">
        <div>
          <h2 class="text-lg font-bold">One Piece</h2>
          <p class="text-sm">Oda Ishiro</p>
        </div>
        <div class="flex items-center gap-4">
          <span class="bg-white text-blue-600 text-xs font-bold px-2 py-1 rounded">Manga</span>
          <span class="text-xs">Chapter 1012</span>
        </div>
        <div class="flex items-center justify-between text-sm">
          <span>45 minutes ago</span>
          <span class="font-bold">9.26</span>
        </div>
      </div>
    </div>

    <!-- Card Item -->
    <div class="flex bg-blue-600 rounded-lg overflow-hidden shadow-md">
      <!-- Thumbnail -->
      <img src="/Assets/Poster book/Solo Leveling.png" alt="Thumbnail" class="w-24 h-auto">
      <!-- Content -->
      <div class="flex flex-col justify-between p-4 text-white flex-1">
        <div>
          <h2 class="text-lg font-bold">Solo Leveling</h2>
          <p class="text-sm">Seong-rak Jang</p>
        </div>
        <div class="flex items-center gap-4">
          <span class="bg-white text-blue-600 text-xs font-bold px-2 py-1 rounded">Manhwa</span>
          <span class="text-xs">Chapter 124</span>
        </div>
        <div class="flex items-center justify-between text-sm">
          <span>2 hours ago</span>
          <span class="font-bold">9.36</span>
        </div>
      </div>
    </div>

    <!-- Card Item -->
  <div>
    <a href="index.php?modul=detailKomik">
    <div class="flex bg-blue-600 rounded-lg overflow-hidden shadow-md">
      <!-- Thumbnail -->
      <img src="../Assets/Poster book/vindland saga poster 1.png" alt="Thumbnail" class="w-24 h-auto">
      <!-- Content -->
      <div class="flex flex-col justify-between p-4 text-white flex-1">
        <div>
          <h2 class="text-lg font-bold">Vinland Saga</h2>
          <p class="text-sm">Makoto Yukimura.</p>
        </div>
        <div class="flex items-center gap-4">
          <span class="bg-white text-blue-600 text-xs font-bold px-2 py-1 rounded">Manhwa</span>
          <span class="text-xs">Chapter 124</span>
        </div>
        <div class="flex items-center justify-between text-sm">
          <span>23 hours ago</span>
          <span class="font-bold">9.36</span>
        </div>
      </div>
    </div>
    </a>
    </div>

    <!-- Card Item -->
    <div class="flex bg-blue-600 rounded-lg overflow-hidden shadow-md">
      <!-- Thumbnail -->
      <img src="/Assets/Poster book/Versatile Mage.png" alt="Thumbnail" class="w-24 h-auto">
      <!-- Content -->
      <div class="flex flex-col justify-between p-4 text-white flex-1">
        <div>
          <h2 class="text-lg font-bold">Versatile Mage</h2>
          <p class="text-sm">Chaos</p>
        </div>
        <div class="flex items-center gap-4">
          <span class="bg-white text-blue-600 text-xs font-bold px-2 py-1 rounded">Manhwa</span>
          <span class="text-xs">Chapter 165</span>
        </div>
        <div class="flex items-center justify-between text-sm">
          <span>2 hours ago</span>
          <span class="font-bold">8.78</span>
        </div>
      </div>
    </div>
  </div>
</div>

    <!-- Fotter  -->
    <?php include 'includes/footer/uFooter.php'; ?>
</body>
</html>