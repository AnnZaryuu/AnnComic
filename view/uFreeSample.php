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
    <title>Free Sample Comic</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-b from-gray-900 via-gray-800 to-gray-900 text-white min-h-screen">
    <!-- Navbar -->
    <?php include 'includes/navbar/uNavbar.php'; ?>

    <div class="container mx-auto py-10 px-5">
        <div class="bg-gray-800 rounded-lg shadow-lg p-8">
            <!-- Header -->
            <h1 class="text-4xl font-extrabold text-center text-teal-400 mb-6">Free Sample Comic</h1>
            <p class="text-center text-gray-400 mb-8">Read a free sample of your favorite manga before unlocking the full content!</p>

            <!-- Comic Viewer Section -->
            <div class="relative border-4 border-teal-500 rounded-lg shadow-xl overflow-hidden">
                <iframe 
                    src="<?php echo $komik->freeSample; ?>#page=1&view=FitH&toolbar=0&navpanes=0&scrollbar=0" 
                    class="w-full h-[80vh]" 
                    frameborder="0">
                </iframe>
            </div>

            <!-- Restriction Notice -->
            <div class="mt-4 text-center text-gray-400 text-sm">
                <p>This is a free sample. Only the first few pages are available. To unlock the full version, please purchase or subscribe.</p>
            </div>

            <!-- Unlock Full Version Button -->
            <div class="mt-6 flex justify-center">
                <a 
                    href="subscription_or_purchase_link_here" 
                    class="bg-teal-500 hover:bg-teal-600 text-white font-bold py-2 px-6 rounded-lg shadow-md hover:shadow-lg transition">
                    Unlock Full Version
                </a>
            </div>
        </div>

        <!-- Footer -->
        <?php include 'includes/footer/uFooter.php'; ?>
        
    </div>
</body>
</html>
