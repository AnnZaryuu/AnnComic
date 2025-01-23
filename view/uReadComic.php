<?php
require_once __DIR__ . '/../models/user_model.php';
require_once __DIR__ . '/../models/komik_model.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$userModel = new UserModel();
$komikModel = new KomikModel();
$userId = $_SESSION['user_id'];
$comicId = $_GET['id'] ?? null;
$rawChapterNumber = $_GET['chapter'] ?? null;

// Extract numeric part from the chapter string
preg_match('/\d+/', $rawChapterNumber, $matches);
$chapterNumber = isset($matches[0]) ? intval($matches[0]) : 0;

if (!$comicId || !$chapterNumber) {
    echo "Comic ID or chapter not provided. Received comicId: " . htmlspecialchars($comicId) . " and rawChapterNumber: " . htmlspecialchars($rawChapterNumber) . " and chapterNumber: " . htmlspecialchars($chapterNumber);
    exit;
}

$comic = $komikModel->getKomikById($comicId);
$purchasedComics = $userModel->getPurchasedComics($userId);
$rentedComics = $userModel->getRentedComics($userId);

if (!$comic) {
    echo "Comic not found!";
    exit;
}

// Check if the user has access to the comic
$hasAccess = false;
if (isset($purchasedComics[$comicId])) {
    foreach ($purchasedComics[$comicId] as $purchasedChapterNumber => $value) {
        if (intval($purchasedChapterNumber) == $chapterNumber) {
            $hasAccess = true;
            break;
        }
    }
}

if (!$hasAccess && isset($rentedComics[$comicId])) {
    foreach ($rentedComics[$comicId] as $rentedChapterNumber => $expiryDate) {
        if (intval(preg_replace('/\D/', '', $rentedChapterNumber)) == $chapterNumber) {
            $hasAccess = true;
            break;
        }
    }
}

if (!$hasAccess) {
    echo "You do not have access to this comic.";
    exit;
}

$chapter = null;
foreach ($comic->chapters as $ch) {
    if (intval($ch->number) == $chapterNumber) {
        $chapter = $ch;
        break;
    }
}

if (!$chapter) {
    echo "Chapter not found! Available chapters: ";
    foreach ($comic->chapters as $ch) {
        echo htmlspecialchars($ch->number) . " ";
    }
    exit;
}

// Ensure the file path is correct and the file exists
if (!file_exists($chapter->filePath)) {
    echo "The requested resource " . htmlspecialchars($chapter->filePath) . " was not found on this server.";
    exit;
}

// Convert the file path to a web-accessible path
$webFilePath = str_replace($_SERVER['DOCUMENT_ROOT'], '', realpath($chapter->filePath));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Read Comic</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-b from-gray-900 via-gray-800 to-gray-900 text-white min-h-screen">
    <!-- Navbar -->
    <?php include 'includes/navbar/uNavbar.php'; ?>

    <div class="container mx-auto py-10 px-5">
        <div class="bg-gray-800 rounded-lg shadow-lg p-8">
            <!-- Header -->
            <h1 class="text-4xl font-extrabold text-center text-teal-400 mb-6"><?= htmlspecialchars($comic->judul) ?> - Chapter <?= htmlspecialchars($chapter->number) ?></h1>
            <p class="text-center text-gray-400 mb-8">Enjoy reading the chapter you own or rented!</p>

            <!-- Comic Viewer Section -->
            <div class="relative border-4 border-teal-500 rounded-lg shadow-xl overflow-hidden">
                <embed 
                    src="<?= htmlspecialchars($webFilePath) ?>" 
                    type="application/pdf" 
                    class="w-full h-[80vh]" />
            </div>
        </div>
        <!-- Footer -->
        <?php include 'includes/footer/uFooter.php'; ?>
    </div>
</body>
</html>
