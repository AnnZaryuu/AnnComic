<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Library User</title>
</head>
<body>
        <!-- Navbar -->
        <?php include 'includes/navbar/uNavbar.php'; ?>

        <?php
        require_once __DIR__ . '/../models/user_model.php';
        require_once __DIR__ . '/../models/komik_model.php';

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $userModel = new UserModel();
        $komikModel = new KomikModel();
        $userId = $_SESSION['user_id'];
        $purchasedComics = $userModel->getPurchasedComics($userId);
        $rentedComics = $userModel->getRentedComics($userId); // Get rented comics
        ?>

        <div class="bg-gray-900 min-h-screen py-8">
            <div class="max-w-6xl mx-auto space-y-4">
                <h1 class="text-3xl font-bold mb-6 text-white">Your Library</h1>
                <?php foreach ($purchasedComics as $comicId): ?>
                    <?php $comic = $komikModel->getKomikById($comicId); ?>
                    <div class="flex bg-blue-600 rounded-lg overflow-hidden shadow-md">
                        <img src="<?= htmlspecialchars($comic->image) ?>" alt="Thumbnail" class="w-24 h-auto">
                        <div class="flex flex-col justify-between p-4 text-white flex-1">
                            <div>
                                <h2 class="text-lg font-bold"><?= htmlspecialchars($comic->judul) ?></h2>
                                <p class="text-sm"><?= htmlspecialchars($comic->penulis) ?></p>
                            </div>
                            <div class="flex items-center gap-4">
                                <span class="bg-white text-blue-600 text-xs font-bold px-2 py-1 rounded"><?= htmlspecialchars($comic->genre[0]) ?></span>
                                <span class="text-xs">Chapter <?= htmlspecialchars($comic->chapters[0]->number) ?></span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <a href="view/uReadComic.php?id=<?= $comic->id ?>&chapter=<?= urlencode($comic->chapters[0]->number) ?>" class="text-blue-400 hover:text-blue-600">Read</a>
                                <span class="font-bold"><?= htmlspecialchars($comic->rating) ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <?php foreach ($rentedComics as $comicId => $expiryDate): ?>
                    <?php $comic = $komikModel->getKomikById($comicId); ?>
                    <div class="flex bg-yellow-600 rounded-lg overflow-hidden shadow-md">
                        <img src="<?= htmlspecialchars($comic->image) ?>" alt="Thumbnail" class="w-24 h-auto">
                        <div class="flex flex-col justify-between p-4 text-white flex-1">
                            <div>
                                <h2 class="text-lg font-bold"><?= htmlspecialchars($comic->judul) ?></h2>
                                <p class="text-sm"><?= htmlspecialchars($comic->penulis) ?></p>
                            </div>
                            <div class="flex items-center gap-4">
                                <span class="bg-white text-yellow-600 text-xs font-bold px-2 py-1 rounded"><?= htmlspecialchars($comic->genre[0]) ?></span>
                                <span class="text-xs">Chapter <?= htmlspecialchars($comic->chapters[0]->number) ?></span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <a href="view/uReadComic.php?id=<?= $comic->id ?>&chapter=<?= urlencode($comic->chapters[0]->number) ?>" class="text-yellow-400 hover:text-yellow-600">Read</a>
                                <span class="font-bold"><?= htmlspecialchars($comic->rating) ?></span>
                                <span class="text-xs">Expires on: <?= htmlspecialchars($expiryDate) ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Footer -->
        <?php include 'includes/footer/uFooter.php'; ?>
</body>
</html>