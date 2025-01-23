<!-- management-keuangan-crud.php -->
<?php
require_once __DIR__ . '/../../models/user_model.php';

$userModel = new UserModel();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['approve'])) {
    $userId = $_POST['user_id'];
    $amount = $_POST['amount'];
    $userModel->approveTopUp($userId, $amount);
    // Remove the approved request from the session
    foreach ($_SESSION['topUpRequests'] as $key => $request) {
        if ($request['userId'] == $userId && $request['amount'] == $amount) {
            unset($_SESSION['topUpRequests'][$key]);
            break;
        }
    }
    $_SESSION['topUpRequests'] = array_values($_SESSION['topUpRequests']); // Reindex array

    // Clear the pending message for the user
    unset($_SESSION['pendingMessage']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Management Keuangan CRUD</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <?php include __DIR__ . '/../includes/sidebar/sidebarAdmin.php'; ?>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            <header class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800">CRUD Management Keuangan</h1>
            </header>
            <section class="mb-6">
                <form action="" method="POST" class="bg-white p-6 rounded shadow-md">
                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 font-bold mb-2">Deskripsi</label>
                        <input type="text" id="description" name="description" class="w-full border border-gray-300 rounded px-3 py-2" placeholder="Masukkan deskripsi" required>
                    </div>
                    <div class="mb-4">
                        <label for="amount" class="block text-gray-700 font-bold mb-2">Jumlah</label>
                        <input type="number" id="amount" name="amount" class="w-full border border-gray-300 rounded px-3 py-2" placeholder="Masukkan jumlah" required>
                    </div>
                    <div class="mb-4">
                        <label for="date" class="block text-gray-700 font-bold mb-2">Tanggal</label>
                        <input type="date" id="date" name="date" class="w-full border border-gray-300 rounded px-3 py-2" required>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
                    </div>
                </form>
            </section>
            <section>
                <h2 class="text-xl font-bold text-gray-800 mb-4">Top-Up Requests</h2>
                <table class="min-w-full bg-white border border-gray-200 mb-6">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="px-4 py-2">User ID</th>
                            <th class="px-4 py-2">Amount</th>
                            <th class="px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($_SESSION['topUpRequests']) && !empty($_SESSION['topUpRequests'])): ?>
                            <?php foreach ($_SESSION['topUpRequests'] as $request): ?>
                                <tr class="border-b">
                                    <td class="px-4 py-2"><?= htmlspecialchars($request['userId']) ?></td>
                                    <td class="px-4 py-2"><?= htmlspecialchars($request['amount']) ?></td>
                                    <td class="px-4 py-2">
                                        <form method="POST" action="">
                                            <input type="hidden" name="user_id" value="<?= htmlspecialchars($request['userId']) ?>">
                                            <input type="hidden" name="amount" value="<?= htmlspecialchars($request['amount']) ?>">
                                            <button type="submit" name="approve" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Approve</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="px-4 py-2 text-center">No top-up requests</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <h2 class="text-xl font-bold text-gray-800 mb-4">Transactions</h2>
                <table class="min-w-full bg-white border border-gray-200">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="px-4 py-2">No</th>
                            <th class="px-4 py-2">Deskripsi</th>
                            <th class="px-4 py-2">Jumlah</th>
                            <th class="px-4 py-2">Tanggal</th>
                            <th class="px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b">
                            <td class="px-4 py-2">1</td>
                            <td class="px-4 py-2">Penjualan Buku</td>
                            <td class="px-4 py-2">Rp 1,000,000</td>
                            <td class="px-4 py-2">2025-01-01</td>
                            <td class="px-4 py-2 text-blue-500">Edit | Delete</td>
                        </tr>
                        <tr class="border-b">
                            <td class="px-4 py-2">2</td>
                            <td class="px-4 py-2">Pembelian Barang</td>
                            <td class="px-4 py-2">Rp 500,000</td>
                            <td class="px-4 py-2">2025-01-02</td>
                            <td class="px-4 py-2 text-blue-500">Edit | Delete</td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</body>
</html>
