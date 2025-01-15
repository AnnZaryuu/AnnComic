<?php
session_start();
require_once __DIR__ . '/../models/komik_model.php';
require_once __DIR__ . '/../models/user_model.php';

$komikId = $_GET['id'] ?? null;
$userId = $_SESSION['user_id'] ?? null;
$chapter = $_GET['chapter'] ?? null;

$userModel = new UserModel();
$komikModel = new KomikModel();

if ($komikId && $userId) {
    $komik = $komikModel->getKomikById($komikId);
    $isRented = $userModel->isComicInLibrary($userId, $komikId);

    if ($komik && $isRented) {
        // Ensure the file path is correct
        $filePath = __DIR__ . "/../Assets/Comic/Manga/" . $komik->judul . "/" . $komik->judul . "_Chapter{$chapter}.pdf";

        // Debugging information
        echo "<pre>Debugging Info:\n";
        echo "File path: $filePath\n";
        echo "File exists: " . (file_exists($filePath) ? 'Yes' : 'No') . "\n";
        echo "Is readable: " . (is_readable($filePath) ? 'Yes' : 'No') . "\n";
        echo "Current directory: " . __DIR__ . "\n";
        echo "Files in directory:\n";

        $dirPath = __DIR__ . '/../Assets/Comic/Manga/' . $komik->judul . '/';
        if (is_dir($dirPath)) {
            $files = scandir($dirPath);
            foreach ($files as $file) {
                echo $file . "\n";
            }
        } else {
            echo "Directory does not exist: $dirPath\n";
        }

        echo "</pre>";

        if (!file_exists($filePath)) {
            echo "<p>The requested resource was not found on this server.</p>";
            exit;
        }
    } else {
        echo "<p>You do not have access to this comic.</p>";
        exit;
    }
} else {
    echo "<p>Comic ID or User ID not provided.</p>";
    exit;
}
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
    <?php include __DIR__ . '/../view/includes/navbar/uNavbar.php'; ?>

    <div class="container mx-auto py-10 px-5">
        <div class="bg-gray-800 rounded-lg shadow-lg p-8">
            <!-- Header -->
            <h1 class="text-4xl font-extrabold text-center text-teal-400 mb-6">Read Comic</h1>
            <p class="text-center text-gray-400 mb-8">Enjoy reading your favorite manga in a sleek and modern viewer.</p>

            <!-- Comic Viewer Section -->
            <div class="relative border-4 border-teal-500 rounded-lg shadow-xl overflow-hidden">
                <iframe 
                    src="<?= htmlspecialchars($filePath) ?>#toolbar=0" 
                    class="w-full h-[80vh]" 
                    frameborder="0">
                </iframe>
            </div>

            <!-- Download Button -->
            <div class="mt-8 flex justify-center">
                <a 
                    href="<?= htmlspecialchars($filePath) ?>" 
                    download 
                    class="bg-teal-500 hover:bg-teal-600 text-white font-bold py-2 px-6 rounded-lg shadow-md hover:shadow-lg transition">
                    Download PDF
                </a>
            </div>
        </div>

        <!-- Footer -->
        <?php include __DIR__ . '/../view/includes/footer/uFooter.php'; ?>
        
    </div>
</body>
</html>
