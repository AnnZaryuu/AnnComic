<?php
require_once __DIR__ . '/../../models/admin_model.php';

$adminModel = new AdminModel();
$userId = $_GET['id'] ?? null;
$user = $adminModel->getUserById($userId);

if (!$user) {
    die("User not found.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $saldo = $_POST['saldo'];
    $password = $_POST['password'];
    $hash_password = password_hash($password, PASSWORD_DEFAULT);

    $adminModel->updateUser($userId, $name, $email, $saldo, $user->profilePicture, $hash_password);
    header('Location: index.php?modul=user');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <?php include __DIR__ . '/../includes/sidebar/sidebarAdmin.php'; ?>
        <!-- Main Content -->
        <main class="flex-1 p-6">
            <header class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Update User</h1>
            </header>
            <section>
                <form action="" method="POST">
                    <div class="space-y-4">
                        <div class="flex items-center bg-gray-700 rounded px-3 py-2">
                            <label for="name" class="text-gray-400 mr-3">Name</label>
                            <input type="text" id="name" name="name" value="<?= htmlspecialchars($user->name) ?>" class="bg-transparent flex-grow focus:outline-none text-white">
                        </div>

                        <div class="flex items-center bg-gray-700 rounded px-3 py-2">
                            <label for="email" class="text-gray-400 mr-3">Email</label>
                            <input type="email" id="email" name="email" value="<?= htmlspecialchars($user->email) ?>" class="bg-transparent flex-grow focus:outline-none text-white">
                        </div>

                        <div class="flex items-center bg-gray-700 rounded px-3 py-2">
                            <label for="saldo" class="text-gray-400 mr-3">Saldo</label>
                            <input type="number" id="saldo" name="saldo" value="<?= htmlspecialchars($user->saldo) ?>" class="bg-transparent flex-grow focus:outline-none text-white">
                        </div>

                        <div class="flex items-center bg-gray-700 rounded px-3 py-2">
                            <label for="password" class="text-gray-400 mr-3">Password</label>
                            <input type="password" id="password" name="password" class="bg-transparent flex-grow focus:outline-none text-white">
                        </div>
                    </div>

                    <div class="mt-6 text-right">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Update</button>
                    </div>
                </form>
            </section>
        </main>
    </div>
</body>
</html>
