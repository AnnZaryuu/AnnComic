<?php
require_once __DIR__ . '/../models/user_model.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    // Handle the case where the user is not logged in
    header('Location: index.php?modul=login');
    exit();
}

$userModel = new UserModel();
$user = $userModel->getUserById($_SESSION['user_id']);

if (!$user) {
    header('Location: index.php?modul=logout');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['topup'])) {
    $amount = $_POST['topup_amount'];
    $userModel->requestTopUp($_SESSION['user_id'], $amount);
    $_SESSION['pendingMessage'] = "Top-up request of $amount IDR is pending approval.";
}

$pendingMessage = $_SESSION['pendingMessage'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Untuk chart -->
    <script src="https://cdn.tailwindcss.com"></script> <!-- Tailwind -->
</head>
<body class="bg-gray-900 text-white" style="background-image: url('../Assets/Wallpaper_background.jpg'); background-size: cover; background-position: center;">

    <!-- Navbar -->
    <?php include 'includes/navbar/uNavbar.php'; ?>

    <!-- Profile Page -->
    <div class="flex justify-center items-center min-h-screen mt-4">
        <div class="bg-gray-800 p-8 rounded-lg shadow-lg w-full max-w-md">
            <!-- Profile Header -->
            <div class="flex items-center gap-4">
                <img src="<?= htmlspecialchars($user->profilePicture ?? '') ?>" alt="Profile Picture" class="rounded-full w-24 h-24">
                <div>
                    <h2 class="text-2xl font-bold"><?= htmlspecialchars($user->name ?? '') ?></h2>
                    <p class="text-sm">Saldo: <?= htmlspecialchars($user->saldo ?? '0') ?> IDR</p>
                    <button onclick="window.location.href='index.php?modul=editProfile&profile_picture=<?= urlencode($user->profilePicture ?? '') ?>'" class="text-blue-400 hover:underline text-sm">Edit Profile</button>
                    <button onclick="document.getElementById('topupModal').classList.remove('hidden')" class="text-green-400 hover:underline text-sm">Top-Up Saldo</button>
                </div>
            </div>

            <?php if (isset($pendingMessage)): ?>
                <div class="bg-yellow-500 text-black p-4 rounded mb-4">
                    <?= htmlspecialchars($pendingMessage) ?>
                </div>
            <?php endif; ?>

            <!-- Status List -->
            <ul class="mt-4 space-y-1 text-sm">
                <li><span class="text-blue-500">3</span> : Reading</li>
                <li><span class="text-yellow-500">1</span> : Want to read</li>
                <li><span class="text-green-500">1</span> : Stalled</li>
                <li><span class="text-gray-500">0</span> : Dropped</li>
                <li><span class="text-gray-500">0</span> : Won't read</li>
                <li><span class="text-orange-500">4</span> : Favourite</li>
            </ul>

            <!-- Chart -->
            <div class="mt-6">
                <canvas id="statusChart"></canvas>
            </div>

            <!-- Chapter Count -->
            <p class="mt-4 text-center text-sm">1142: Number of chapters you have read</p>

            <!-- Logout Button -->
            <div class="mt-4 text-center">
                <button onclick="window.location.href='index.php?modul=logout'" class="bg-pink-500 text-white py-2 px-4 rounded-lg hover:bg-pink-600">
                    Log out
                </button>
            </div>
        </div>
    </div>

    <!-- Top-Up Modal -->
    <div id="topupModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-75 flex justify-center items-center">
        <div class="bg-gray-800 p-8 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-xl font-bold mb-4">Top-Up Saldo</h2>
            <form method="POST" action="">
                <input type="hidden" name="topup" value="true">
                <div class="mb-4">
                    <label for="topup_amount" class="block text-sm font-medium text-gray-300">Top-Up Amount</label>
                    <input type="number" name="topup_amount" id="topup_amount" class="mt-1 block w-full bg-gray-700 border-gray-600 text-white rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500 sm:text-sm" required>
                </div>
                <div class="flex justify-end">
                    <button type="button" onclick="document.getElementById('topupModal').classList.add('hidden')" class="text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center mr-2">Cancel</button>
                    <button type="submit" class="text-white bg-green-500 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Top-Up</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Data untuk Chart (Bisa dinamis dari backend)
        const data = {
            labels: ['Reading', 'Want to read', 'Stalled', 'Dropped', 'Won\'t read', 'Favourite'],
            datasets: [{
                data: [3, 1, 1, 0, 0, 4],
                backgroundColor: ['#3B82F6', '#FACC15', '#22C55E', '#6B7280', '#4B5563', '#F97316'],
                hoverOffset: 4
            }]
        };

        // Konfigurasi Chart
        const config = {
            type: 'doughnut',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            color: 'white'
                        }
                    }
                }
            }
        };

        // Render Chart
        const ctx = document.getElementById('statusChart').getContext('2d');
        new Chart(ctx, config);
    </script>
</body>
</html>
