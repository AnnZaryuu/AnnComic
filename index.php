<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/models/komik_model.php';
require_once __DIR__ . '/models/user_model.php';

session_start();

if (!isset($_SESSION['user_id']) && (!isset($_GET['modul']) || $_GET['modul'] != 'login')) {
    header('Location: index.php?modul=login');
    exit;
}

$modul = $_GET['modul'] ?? 'dashboard';

switch ($modul) {
    case 'login':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['Email'];
            $password = $_POST['password'];

            $userModel = new UserModel();
            $user = $userModel->getUserByEmail($email);

            if ($user && password_verify($password, $user->password)) {
                $_SESSION['user_id'] = $user->userId;
                $_SESSION['username'] = $user->name;

                if ($user->name === 'admin') {
                    header('Location: index.php?modul=admin');
                } else {
                    header('Location: index.php?modul=dashboard');
                }
                exit;
            } else {
                $error = "Email atau password salah!";
            }
        }
        include 'view/uLogin.php';
        break;

    case 'register':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $hash_password = password_hash($password, PASSWORD_DEFAULT);

            $userModel = new UserModel();
            $userModel->addUser(new NodeUser(null, $name, $email, $hash_password));

            header('Location: index.php?modul=login');
            exit;
        }
        include 'view/uRegister.php';
        break;

    case 'logout':
        session_start();
        session_unset();
        session_destroy();

        header('Location: index.php?modul=login');
        break;

    case 'dashboard':
        include __DIR__ . '/view/uHome.php';
        break;

    case 'komik':
        $fitur = $_GET['fitur'] ?? null;
        $komikModel = new KomikModel();

        switch ($fitur) {
            case 'add':
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $judul = $_POST['judul'];
                    $penulis = $_POST['penulis'];
                    $penerbit = $_POST['penerbit'];
                    $harga = $_POST['harga'];
                    $genre = $_POST['genre'];
                    $komikModel->addKomik(new Komik(null, $judul, $penulis, $penerbit, $harga, $genre));
                    header('Location: index.php?modul=komik');
                    exit;
                } else {
                    include 'view/komik_input.php';
                }
                break;

            case 'edit':
                $id = $_GET['id'] ?? null;
                if (!$id) {
                    die("ID komik tidak ditemukan.");
                }
                $komik = $komikModel->getKomikById($id);
                if (!$komik) {
                    die("Komik tidak ditemukan.");
                }
                include 'view/komik_update.php';
                break;

            case 'update':
                $idKomik = $_GET['id'] ?? null;
                if (!$idKomik) {
                    die("ID komik tidak ditemukan.");
                }
                $komik = $komikModel->getKomikById($idKomik);
                if (!$komik) {
                    die("Komik tidak ditemukan.");
                }
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $judul = $_POST['judul'];
                    $penulis = $_POST['penulis'];
                    $penerbit = $_POST['penerbit'];
                    $harga = $_POST['harga'];
                    $genre = $_POST['genre'];
                    $komikModel->updateKomik($idKomik, $judul, $penulis, $penerbit, $harga, $genre);
                    header('Location: index.php?modul=komik');
                    exit;
                }
                break;

            case 'delete':
                $id = $_GET['id'] ?? null;
                if (!$id) {
                    die("ID komik tidak ditemukan.");
                }
                $cek = $komikModel->getKomikById($id);
                if (!$cek) {
                    die('Komik tidak ditemukan!');
                }
                $komikModel->deleteKomik($id);
                header('Location: index.php?modul=komik');
                exit;

            default:
                $komiks = $komikModel->getKomikList();
                include 'view/komik_list.php';
                break;
        }
        break;

    case 'user':
        $fitur = $_GET['fitur'] ?? null;
        $userModel = new UserModel();

        switch ($fitur) {
            case 'add':
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $name = $_POST['name'];
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    $hash_password = password_hash($password, PASSWORD_DEFAULT);
                    $userModel->addUser(new NodeUser(null, $name, $email, $hash_password));
                    header('Location: index.php?modul=user');
                    exit;
                } else {
                    include 'view/user_input.php';
                }
                break;

            case 'edit':
                $id = $_GET['id'] ?? null;
                if (!$id) {
                    die("ID user tidak ditemukan.");
                }
                $user = $userModel->getUserById($id);
                if (!$user) {
                    die("User tidak ditemukan.");
                }
                include 'view/user_update.php';
                break;

            case 'update':
                $idUser = $_GET['id'] ?? null;
                if (!$idUser) {
                    die("ID user tidak ditemukan.");
                }
                $user = $userModel->getUserById($idUser);
                if (!$user) {
                    die("User tidak ditemukan.");
                }
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $name = $_POST['name'];
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    $hash_password = password_hash($password, PASSWORD_DEFAULT);
                    $userModel->updateUser($idUser, $name, $email, $hash_password);
                    header('Location: index.php?modul=user');
                    exit;
                }
                break;

            case 'delete':
                $id = $_GET['id'] ?? null;
                if (!$id) {
                    die("ID user tidak ditemukan.");
                }
                $cek = $userModel->getUserById($id);
                if (!$cek) {
                    die('User tidak ditemukan!');
                }
                $userModel->deleteUser($id);
                header('Location: index.php?modul=user');
                exit;

            default:
                $users = $userModel->getUserList();
                include 'view/user_list.php';
                break;
        }
        break;

    case 'readComic':
        include __DIR__ . '/view/uReadComic.php';
        break;

    case 'listKomik':
        include __DIR__ . '/view/uListKomik.php';
        break;

    case 'library':
        include __DIR__ . '/view/uLibrary.php';
        break;

    case 'home':
        include __DIR__ . '/view/uHome.php';
        break;

    case 'detailKomik':
        include __DIR__ . '/view/uDetailkomik.php';
        break;

    case 'chapter':
        include __DIR__ . '/view/uChapter.php';
        break;

    default:
        include 'view/kosong.php';
        break;
}
?>
