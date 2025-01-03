<!-- management-keuangan-crud.php -->
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
        <?php include '../includes/sidebar/sidebarAdmin.php'; ?>

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
