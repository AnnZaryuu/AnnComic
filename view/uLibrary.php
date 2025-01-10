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

        session_start();
        $userModel = new UserModel();
        $komikModel = new KomikModel();
        $userId = $_SESSION['user_id'];
        $purchasedComics = $userModel->getPurchasedComics($userId);
        ?>

        <div class="container mx-auto p-6">
            <h1 class="text-3xl font-bold mb-6">Your Library</h1>
            <div class="bg-gray-800 p-4 rounded-lg shadow-md">
                <?php foreach ($purchasedComics as $comicId): ?>
                    <?php $comic = $komikModel->getKomikById($comicId); ?>
                    <div class="flex items-center justify-between border-b border-gray-700 py-4">
                        <span class="text-lg"><?= htmlspecialchars($comic->judul) ?></span>
                        <a href="read_comic.php?id=<?= $comic->id ?>" class="text-blue-400 hover:text-blue-600">Read</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Fotter  -->
    <?php include 'includes/footer/uFooter.php'; ?>
</body>
</html>