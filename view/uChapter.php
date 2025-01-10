<?php
require_once __DIR__ . '/../models/komik_model.php';

$komikId = $_GET['id'] ?? null;
$komikModel = new KomikModel();
$komik = $komikModel->getKomikById($komikId);

if (!$komik) {
    echo "Komik not found!";
    exit;
}

$dataChapters = $komik->chapter;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chapter List</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
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
<body class="bg-gray-900 text-white">
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6">Chapter List</h1>
        <div class="bg-gray-800 p-4 rounded-lg shadow-md">
            <?php foreach ($dataChapters as $chapter): ?>
                <div class="flex items-center justify-between border-b border-gray-700 py-4">
                    <span class="text-lg">
                        <?= htmlspecialchars($chapter) ?>
                    </span>
                    <div class="flex space-x-4">
                        <a href="read_comic.php?id=<?= $komikId ?>&chapter=<?= urlencode($chapter) ?>" class="text-blue-400 hover:text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-9A2.25 2.25 0 002.25 5.25v9a2.25 2.25 0 002.25 2.25H9" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 15L21 18.75M21 15l-3.75 3.75" />
                            </svg>
                        </a>
                        <a href="download_chapter.php?id=<?= $komikId ?>&chapter=<?= urlencode($chapter) ?>" class="text-blue-400 hover:text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15V21H8.25V15m3.75-6L15 10.5M9 10.5h6M12 3v12" />
                            </svg>
                        </a>
                        <button onclick="confirmPurchase(<?= $komikId ?>, '<?= htmlspecialchars($chapter) ?>')" class="text-green-400 hover:text-green-600">
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

            message.textContent = `Are you sure you want to purchase ${title}?`;
            confirmButton.onclick = function () {
                window.location.href = `index.php?modul=buyChapter&id=${id}`;
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
