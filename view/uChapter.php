<?php
require_once __DIR__ . '/../models/komik_model.php';

$komikId = $_GET['id'] ?? null;
$komikModel = new KomikModel();
$komik = $komikModel->getKomikById($komikId);

if (!$komik) {
    echo "Komik not found!";
    exit;
}

$dataChapters = $komik->chapters;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chapter List</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('../Assets/Wallpaper_background.jpg');
            background-size: cover;
            background-attachment: fixed;
        }
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }
        .modal.active {
            display: flex;
        }
    </style>
</head>
<body class="bg-gray-900 bg-opacity-75 text-white">
    <!-- Navbar -->
    <?php include 'includes/navbar/uNavbar.php'; ?>

    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6">Chapter List</h1>
        <div class="bg-gray-800 p-4 rounded-lg shadow-md">
        <div class="flex items-center mb-4 space-x-2">
            <p class="text-lg">Price:</p>
            <p class="text-lg font-bold bg-green-400 text-white px-2 py-1 rounded"><?= htmlspecialchars($komik->harga) ?> IDR</p>
        </div> 
            <?php foreach ($dataChapters as $chapter): ?>
                <div class="flex items-center justify-between border-b border-gray-700 py-4 rounded-lg">
                    <span class="text-lg">
                        <?= htmlspecialchars($chapter->title) ?>
                    </span>
                    <div class="flex space-x-4">
                        <button onclick="rentChapter(<?= $komikId ?>, '<?= htmlspecialchars($chapter->title) ?>')" class="text-yellow-400 hover:text-yellow-600">
                            Rent
                        </button>
                        <button onclick="confirmPurchase(<?= $komikId ?>, '<?= htmlspecialchars($chapter->title) ?>')" class="text-green-400 hover:text-green-600">
                            Buy Now
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Modal -->
    <div id="purchaseModal" class="modal">
        <div class="bg-gray-800 p-6 rounded-lg text-center">
            <h2 class="text-xl font-bold mb-4">Confirm Purchase</h2>
            <p id="modalMessage" class="mb-6"></p>
            <div class="flex justify-center space-x-4">
                <button id="confirmButton" class="bg-green-500 px-4 py-2 rounded hover:bg-green-700">Confirm</button>
                <button onclick="closeModal()" class="bg-red-500 px-4 py-2 rounded hover:bg-red-700">Cancel</button>
            </div>
        </div>
    </div>

    <script>
        function confirmPurchase(id, title) {
            const modal = document.getElementById('purchaseModal');
            const message = document.getElementById('modalMessage');
            const confirmButton = document.getElementById('confirmButton');

            message.textContent = `Apa kamu yakin membeli komik ini secara permanent ${title}?`;
            confirmButton.onclick = function () {
                window.location.href = `index.php?modul=buyChapter&id=${id}&chapter=${title}`;
            };

            modal.classList.add('active');
        }

        function rentChapter(id, title) {
            const modal = document.getElementById('purchaseModal');
            const message = document.getElementById('modalMessage');
            const confirmButton = document.getElementById('confirmButton');

            message.textContent = `Apa kamu yakin menyewa komik ini selama 3h seharga 50% harga asli ${title}?`;
            confirmButton.onclick = function () {
                window.location.href = `index.php?modul=rentChapter&id=${id}&chapter=${title}`;
            };

            modal.classList.add('active');
        }

        function closeModal() {
            const modal = document.getElementById('purchaseModal');
            modal.classList.remove('active');
        }
    </script>
</body>
</html>
