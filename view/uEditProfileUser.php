<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800&display=swap"
    rel="stylesheet">

<script src="https://cdn.tailwindcss.com"></script>

<style>
    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
</style>

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
    // Handle the case where the user is not found
    header('Location: index.php?modul=logout');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $profilePicture = $user->profilePicture;
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        $uploadFile = $uploadDir . basename($_FILES['profile_picture']['name']);
        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $uploadFile)) {
            $profilePicture = $uploadFile;
        }
    }

    $userModel->updateUser(
        $user->userId,
        $_POST['first_name'],
        $_POST['email'],
        $_POST['profession'],
        $_POST['bio'],
        $profilePicture
    );
    header('Location: index.php?modul=profile');
    exit();
}
?>

<div class="bg-gray-900 w-full min-h-screen text-gray-100 flex flex-col px-3 md:px-16 lg:px-28">
    <main class="w-full py-8">
        <div class="p-4">
            <div class="w-full px-6 pb-8 mt-8 sm:max-w-xl sm:rounded-lg bg-gray-800 shadow-lg">
                <h2 class="pl-6 text-2xl font-bold sm:text-xl text-gray-200">Public Profile</h2>
                <form method="POST" action="index.php?modul=editProfile" enctype="multipart/form-data">
                    <div class="grid max-w-2xl mx-auto mt-8">
                        <div class="flex flex-col items-center space-y-5 sm:flex-row sm:space-y-0">
                            <img class="object-cover w-40 h-40 p-1 rounded-full ring-2 ring-gray-300"
                                src="<?= htmlspecialchars($user->profilePicture) ?>"
                                alt="Bordered avatar">
                            <div class="flex flex-col space-y-5 sm:ml-8">
                                <input type="file" name="profile_picture" class="py-3.5 px-7 text-base font-medium text-gray-900 bg-gray-200 rounded-lg border border-gray-300 hover:bg-gray-300 focus:ring-4 focus:ring-gray-400">
                            </div>
                        </div>
                        <div class="items-center mt-8 sm:mt-14">
                            <div
                                class="flex flex-col items-center w-full mb-2 space-x-0 space-y-2 sm:flex-row sm:space-x-4 sm:space-y-0 sm:mb-6">
                                <div class="w-full">
                                    <label for="first_name"
                                        class="block mb-2 text-sm font-medium text-gray-200">Your first name</label>
                                    <input type="text" id="first_name" name="first_name"
                                        class="bg-gray-700 border border-gray-600 text-gray-100 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5"
                                        placeholder="Your first name" value="<?= htmlspecialchars($user->name) ?>" required>
                                </div>
                                <div class="w-full">
                                    <label for="last_name"
                                        class="block mb-2 text-sm font-medium text-gray-200">Your last name</label>
                                    <input type="text" id="last_name" name="last_name"
                                        class="bg-gray-700 border border-gray-600 text-gray-100 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5"
                                        placeholder="Your last name" value="<?= htmlspecialchars($user->name) ?>" required>
                                </div>
                            </div>
                            <div class="mb-2 sm:mb-6">
                                <label for="email"
                                    class="block mb-2 text-sm font-medium text-gray-200">Your email</label>
                                <input type="email" id="email" name="email"
                                    class="bg-gray-700 border border-gray-600 text-gray-100 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5"
                                    placeholder="your.email@mail.com" value="<?= htmlspecialchars($user->email) ?>" required>
                            </div>
                            <div class="mb-2 sm:mb-6">
                                <label for="profession"
                                    class="block mb-2 text-sm font-medium text-gray-200">Profession</label>
                                <input type="text" id="profession" name="profession"
                                    class="bg-gray-700 border border-gray-600 text-gray-100 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5"
                                    placeholder="Your profession" value="<?= htmlspecialchars($user->profession) ?>" required>
                            </div>
                            <div class="mb-6">
                                <label for="message"
                                    class="block mb-2 text-sm font-medium text-gray-200">Bio</label>
                                <textarea id="message" name="bio" rows="4"
                                    class="block p-2.5 w-full text-sm text-gray-100 bg-gray-700 rounded-lg border border-gray-600 focus:ring-gray-500 focus:border-gray-500"
                                    placeholder="Write your bio here..."><?= htmlspecialchars($user->bio) ?></textarea>
                            </div>
                            <div class="flex justify-end">
                                <button type="submit"
                                    class="text-white bg-indigo-700 hover:bg-indigo-800 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">
                                    Save
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>
