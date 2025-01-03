<!-- add-book.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white">
    <div class="h-screen flex items-center justify-center">
        <div class="bg-gray-800 rounded-lg shadow-lg p-6 w-3/4 max-w-4xl">
            <h1 class="text-2xl font-bold mb-6">Add Your Own Book</h1>
            <div class="grid grid-cols-3 gap-6">
                <!-- Cover Book Section -->
                <div class="bg-gray-300 text-gray-800 rounded-lg flex flex-col items-center justify-center h-64">
                    <div class="text-4xl font-bold">+</div>
                    <p class="font-semibold">ADD COVER BOOK</p>
                </div>

                <!-- Form Section -->
                <div class="col-span-2">
                    <form action="" method="POST">
                        <div class="space-y-4">
                            <div class="flex items-center bg-gray-700 rounded px-3 py-2">
                                <span class="material-icons text-gray-400 mr-3">title</span>
                                <input type="text" name="title" placeholder="Add Title" class="bg-transparent flex-grow focus:outline-none text-white">
                            </div>

                            <div class="flex items-center bg-gray-700 rounded px-3 py-2">
                                <span class="material-icons text-gray-400 mr-3">person</span>
                                <input type="text" name="author" placeholder="Author" class="bg-transparent flex-grow focus:outline-none text-white">
                            </div>

                            <div class="flex items-center bg-gray-700 rounded px-3 py-2">
                                <span class="material-icons text-gray-400 mr-3">language</span>
                                <input type="text" name="language" placeholder="Language" class="bg-transparent flex-grow focus:outline-none text-white">
                            </div>

                            <div class="flex items-center bg-gray-700 rounded px-3 py-2">
                                <span class="material-icons text-gray-400 mr-3">publish</span>
                                <input type="text" name="publisher" placeholder="Publisher" class="bg-transparent flex-grow focus:outline-none text-white">
                            </div>

                            <div class="flex items-start bg-gray-700 rounded px-3 py-2">
                                <span class="material-icons text-gray-400 mr-3">description</span>
                                <textarea name="synopsis" placeholder="Synopsis" class="bg-transparent flex-grow focus:outline-none text-white resize-none h-20"></textarea>
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-4 mt-6">
                            <input type="date" name="release_date" placeholder="Release Date" class="bg-gray-700 rounded px-3 py-2 text-white focus:outline-none">
                            <input type="number" name="stock" placeholder="Stock" class="bg-gray-700 rounded px-3 py-2 text-white focus:outline-none">
                            <input type="number" name="price" placeholder="Price" class="bg-gray-700 rounded px-3 py-2 text-white focus:outline-none">
                        </div>

                        <div class="mt-6 text-right">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">DONE</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
