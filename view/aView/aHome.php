<?php
require_once __DIR__ . '/../../models/admin_model.php';

$adminModel = new AdminModel();
$users = $adminModel->getUserList();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page - Comic Website</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<?php include __DIR__ . '/../includes/sidebar/sidebarAdmin.php'; ?>
        <!-- Main Content -->
        <main class="flex-1 p-6">
            <header class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Management User</h1>
            </header>
            <section>
                <table class="min-w-full bg-white border border-gray-200">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="px-4 py-2">No</th>
                            <th class="px-4 py-2">Nama</th>
                            <th class="px-4 py-2">Email</th>
                            <th class="px-4 py-2">Role</th>
                            <th class="px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $index => $user): ?>
                        <tr class="border-b">
                            <td class="px-4 py-2"><?= $index + 1 ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($user->name) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($user->email) ?></td>
                            <td class="px-4 py-2">User</td>
                            <td class="px-4 py-2 text-blue-500">
                                <a href="index.php?modul=user&fitur=edit&id=<?= $user->userId ?>">Edit</a> |
                                <a href="index.php?modul=user&fitur=delete&id=<?= $user->userId ?>">Delete</a>
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
