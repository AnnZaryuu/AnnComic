<?php
require_once __DIR__ . '/../../models/admin_model.php';

$adminModel = new AdminModel();
$komikList = $adminModel->getKomikList();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Management Buku Komik CRUD</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <?php include __DIR__ . '/../includes/sidebar/sidebarAdmin.php'; ?>
        <!-- Main Content -->
        <main class="flex-1 p-6">
            <header class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Buku Komik</h1>
            </header>
            <a href="index.php?modul=adminAddBook">
            <button type="button" class="py-2.5 px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Tambah Buku Baru</button>
            </a>
            <section>
                <table class="min-w-full bg-white border border-gray-200">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="px-4 py-2">No</th>
                            <th class="px-4 py-2">Judul</th>
                            <th class="px-4 py-2">Penulis</th>
                            <th class="px-4 py-2">Genre</th>
                            <th class="px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($komikList as $index => $komik): ?>
                        <tr class="border-b">
                            <td class="px-4 py-2"><?= $index + 1 ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($komik->judul) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($komik->penulis) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars(implode(', ', $komik->genre)) ?></td>
                            <td class="px-4 py-2 text-blue-500">
                                <a href="index.php?modul=komik&fitur=edit&id=<?= $komik->id ?>">Edit</a> |
                                <a href="index.php?modul=komik&fitur=delete&id=<?= $komik->id ?>">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</body>
</html>
