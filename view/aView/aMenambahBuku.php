<?php
require_once __DIR__ . '/../../models/admin_model.php';

$adminModel = new AdminModel();

// Ensure the uploads directories exist
$uploadDirCover = __DIR__ . '/../../Assets/uploads/Poster book/';
$uploadDirBackground = __DIR__ . '/../../Assets/uploads/Poster landscape/';
$uploadDirAuthor = __DIR__ . '/../../Assets/uploads/Author/';
$uploadDirFreeSample = __DIR__ . '/../../Assets/uploads/FreeSample/';
$uploadDirChapter = __DIR__ . '/../../Assets/uploads/Chapters/';

if (!is_dir($uploadDirCover)) {
    mkdir($uploadDirCover, 0777, true);
}
if (!is_dir($uploadDirBackground)) {
    mkdir($uploadDirBackground, 0777, true);
}
if (!is_dir($uploadDirAuthor)) {
    mkdir($uploadDirAuthor, 0777, true);
}
if (!is_dir($uploadDirFreeSample)) {
    mkdir($uploadDirFreeSample, 0777, true);
}
if (!is_dir($uploadDirChapter)) {
    mkdir($uploadDirChapter, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $harga = $_POST['harga'];
    $genre = explode(',', $_POST['genre']); // Convert comma-separated string to array

    // Handle cover image upload
    $coverImage = '';
    if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] == UPLOAD_ERR_OK) {
        $coverImage = 'Assets/uploads/Poster book/' . basename($_FILES['cover_image']['name']);
        move_uploaded_file($_FILES['cover_image']['tmp_name'], $uploadDirCover . basename($_FILES['cover_image']['name']));
    }

    // Handle author image upload
    $authorImage = '';
    if (isset($_FILES['author_image']) && $_FILES['author_image']['error'] == UPLOAD_ERR_OK) {
        $authorImage = 'Assets/uploads/Author/' . basename($_FILES['author_image']['name']);
        move_uploaded_file($_FILES['author_image']['tmp_name'], $uploadDirAuthor . basename($_FILES['author_image']['name']));
    }

    // Handle background image upload
    $backgroundImage = '';
    if (isset($_FILES['background_image']) && $_FILES['background_image']['error'] == UPLOAD_ERR_OK) {
        $backgroundImage = 'Assets/uploads/Poster landscape/' . basename($_FILES['background_image']['name']);
        move_uploaded_file($_FILES['background_image']['tmp_name'], $uploadDirBackground . basename($_FILES['background_image']['name']));
    }

    // Handle free sample file upload
    $freeSample = '';
    if (isset($_FILES['freeSample']) && $_FILES['freeSample']['error'] == UPLOAD_ERR_OK) {
        $freeSample = 'Assets/uploads/FreeSample/' . basename($_FILES['freeSample']['name']);
        move_uploaded_file($_FILES['freeSample']['tmp_name'], $uploadDirFreeSample . basename($_FILES['freeSample']['name']));
    }

    // Create a new folder for the comic in the Manga directory
    $comicDir = __DIR__ . '/../../Assets/Comic/Manga/' . preg_replace('/[^A-Za-z0-9]/', '_', $judul);
    if (!is_dir($comicDir)) {
        mkdir($comicDir, 0777, true);
    }

    // Handle chapter 1 file upload
    $chapterFilePath = '';
    if (isset($_FILES['chapter_file']) && $_FILES['chapter_file']['error'] == UPLOAD_ERR_OK) {
        $chapterFileName = preg_replace('/[^A-Za-z0-9]/', '_', $judul) . '_Chapter1.pdf';
        $chapterFilePath = 'Assets/Comic/Manga/' . basename($comicDir) . '/' . $chapterFileName;
        move_uploaded_file($_FILES['chapter_file']['tmp_name'], $comicDir . '/' . $chapterFileName);
    }

    // Set default chapter
    $chapters = [new Chapter(1, 'Chapter 1', $chapterFilePath)];

    $rating = $_POST['rating'];
    $sinopsis = $_POST['sinopsis'];
    $adminModel->addKomik(new Komik(null, $judul, $penulis, $penerbit, $harga, $genre, $coverImage, $chapters, $rating, $sinopsis, $backgroundImage, $authorImage, $freeSample));
    header('Location: index.php?modul=adminKomikManagement');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-700 text-white">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-gray-800 rounded-lg shadow-2xl p-10 w-full max-w-5xl">
            <h1 class="text-4xl font-bold mb-10 text-center text-blue-400">Add Your Own Book</h1>

            <form action="" method="POST" enctype="multipart/form-data" class="space-y-8">
                <!-- Form Section -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Cover Book Section -->
                    <div class="flex flex-col items-center bg-gray-700 text-gray-300 rounded-lg p-6 h-72 border-2 border-dashed border-gray-600 transition hover:border-blue-400 hover:bg-gray-600">
                        <div class="text-6xl font-bold">+</div>
                        <p class="mt-4 font-semibold text-center">Upload Cover Image</p>
                        <input type="file" name="cover_image" class="mt-4 text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-400 file:text-white hover:file:bg-blue-500">
                    </div>

                    <!-- Input Fields -->
                    <div class="col-span-2 space-y-6">
                        <input type="text" name="judul" placeholder="Title" class="input-field" required>
                        <input type="text" name="penulis" placeholder="Author" class="input-field" required>
                        <input type="text" name="genre" placeholder="Genre (comma separated)" class="input-field" required>
                        <input type="text" name="penerbit" placeholder="Publisher" class="input-field" required>
                        <textarea name="sinopsis" placeholder="Synopsis" class="input-field h-24 resize-none" required></textarea>
                        <div class="grid grid-cols-2 gap-4">
                            <input type="number" name="harga" placeholder="Price" class="input-field" required>
                            <input type="text" name="rating" placeholder="Rating" class="input-field" required>
                        </div>
                        <label class="block">
                            <span class="block text-sm font-medium mb-2">Upload Free Sample</span>
                            <input type="file" name="freeSample" class="file-input">
                        </label>
                        <label class="block">
                            <span class="block text-sm font-medium mb-2">Upload Chapter File</span>
                            <input type="file" name="chapter_file" class="file-input" required>
                        </label>
                    </div>
                </div>

                <!-- Additional Upload Sections -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="upload-card">
                        <div class="text-4xl font-bold">+</div>
                        <p class="mt-4 font-semibold">Upload Background Image</p>
                        <input type="file" name="background_image" class="file-input mt-4">
                    </div>
                    <div class="upload-card">
                        <div class="text-4xl font-bold">+</div>
                        <p class="mt-4 font-semibold">Upload Author Image</p>
                        <input type="file" name="author_image" class="file-input mt-4">
                    </div>
                    <div class="flex items-center justify-center">
                        <button type="submit" class="btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <style>
        .input-field {
            width: 100%;
            background-color: #374151;
            color: white;
            padding: 12px 16px;
            border-radius: 0.5rem;
            border: none;
            outline: none;
            transition: border-color 0.3s ease;
        }

        .input-field:focus {
            border: 2px solid #60A5FA;
        }

        .file-input {
            display: block;
            width: 100%;
            color: #9CA3AF;
            background-color: transparent;
            padding: 8px;
            border: 1px dashed #6B7280;
            border-radius: 0.5rem;
            outline: none;
            transition: border-color 0.3s ease, background-color 0.3s ease;
        }

        .file-input:hover {
            border-color: #60A5FA;
            background-color: #374151;
        }

        .btn-primary {
            width: 100%;
            padding: 12px 16px;
            background-color: #3B82F6;
            color: white;
            font-weight: bold;
            border-radius: 0.5rem;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn-primary:hover {
            background-color: #2563EB;
            transform: translateY(-2px);
        }

        .upload-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background-color: #374151;
            color: #D1D5DB;
            padding: 16px;
            border-radius: 0.5rem;
            height: 12rem;
            border: 2px dashed #6B7280;
            transition: border-color 0.3s ease, background-color 0.3s ease;
        }

        .upload-card:hover {
            border-color: #60A5FA;
            background-color: #4B5563;
        }
    </style>
</body>
</html>
