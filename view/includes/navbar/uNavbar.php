<?php
require_once __DIR__ . '/../../../models/user_model.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$userModel = new UserModel();
$user = $userModel->getUserById($_SESSION['user_id']);
?>

<header class="shadow" style="background-color: #232D3F; position: sticky; top: 0; z-index: 100;">
    <div class="container mx-auto flex justify-between items-center py-4 px-6">
        <!-- Logo -->
        <a href="index.php?modul=home">
            <img src="../../Assets/LOGO.png" alt="AnnZaryuu Comic" class="h-10">
        </a>
        <div class="flex items-center space-x-4">
            <input type="text" placeholder="Search here" class="border border-gray-300 rounded-3xl px-4 py-2 focus:outline-none focus:ring focus:ring-blue-300">
            <a href="index.php?modul=listKomik" class="text-white hover:underline">List Book</a>
            <a href="index.php?modul=library" class="text-white hover:underline">My Library</a>
            <a href="index.php?modul=profile">
                <button class="flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-3xl hover:bg-blue-700">
                    <div class="w-8 h-8 rounded-full overflow-hidden bg-gray-200">
                        <img src="<?= htmlspecialchars($user->profilePicture) ?>" alt="Profile Picture" class="w-full h-full object-cover" />
                    </div>
                    <span><?= htmlspecialchars($user->name) ?></span>
                </button>
            </a>
        </div>
    </div>
</header>
