<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/models/komik_model.php';
require_once __DIR__ . '/models/user_model.php';
require_once __DIR__ . '/models/admin_model.php';

session_start();

if (!isset($_SESSION['user_id']) && !isset($_SESSION['admin_id']) && (!isset($_GET['modul']) || $_GET['modul'] != 'login')) {
    header('Location: index.php?modul=login');
    exit;
}

$modul = $_GET['modul'] ?? 'dashboard';

function handleLogin() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['Email'];
        $password = $_POST['password'];

        $userModel = new UserModel();
        $adminModel = new AdminModel();
        $user = $userModel->getUserByEmail($email);
        $admin = $adminModel->getAdminByEmail($email);

        if ($user && password_verify($password, $user->password)) {
            $_SESSION['user_id'] = $user->userId;
            $_SESSION['username'] = $user->name;
            header('Location: index.php?modul=dashboard');
            exit;
        } elseif ($admin && password_verify($password, $admin->password)) {
            $_SESSION['admin_id'] = $admin->id_admin;
            $_SESSION['username'] = $admin->nama;
            echo "<script>
                window.open('index.php?modul=adminHome', '_blank');
                window.location.href = 'index.php';
            </script>";
            exit;
        } else {
            $error = "Email atau password salah!";
        }
    }
    include 'view/uLogin.php';
}

function handleRegister() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $hash_password = password_hash($password, PASSWORD_DEFAULT);

        $userModel = new UserModel();
        $userModel->addUser(new User(null, $name, $email, $hash_password));

        header('Location: index.php?modul=login');
        exit;
    }
    include 'view/uRegister.php';
}

function handleLogout() {
    session_start();
    session_unset();
    session_destroy();
    header('Location: index.php?modul=login');
}

function handleDashboard() {
    if (isset($_SESSION['admin_id'])) {
        header('Location: index.php?modul=adminHome');
        exit;
    }
    include __DIR__ . '/view/uHome.php';
}

function handleAdminHome() {
    include __DIR__ . '/view/aView/aHome.php';
}

function handleKomik() {
    $fitur = $_GET['fitur'] ?? null;
    $komikModel = new KomikModel();

    switch ($fitur) {
        case 'add':
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $judul = $_POST['judul'];
                $penulis = $_POST['penulis'];
                $penerbit = $_POST['penerbit'];
                $harga = $_POST['harga'];
                $genre = explode(',', $_POST['genre']);
                $image = $_POST['image'];
                $chapters = [];
                foreach (explode(',', $_POST['chapter']) as $chapter) {
                    list($number, $title, $filePath) = explode(':', $chapter);
                    $chapters[] = new Chapter($number, $title, $filePath);
                }
                $rating = $_POST['rating'];
                $sinopsis = $_POST['sinopsis'];
                $background = $_POST['background'];
                $author = $_POST['author'];
                $freeSample = $_POST['freeSample'];
                $komikModel->addKomik(new Komik(null, $judul, $penulis, $penerbit, $harga, $genre, $image, $chapters, $rating, $sinopsis, $background, $author, $freeSample));
                header('Location: index.php?modul=adminKomikManagement');
                exit;
            } else {
                include 'view/aView/aMenambahBuku.php';
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
            include 'view/aView/aEditKomik.php';
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
                $genre = explode(',', $_POST['genre']);
                $image = $_POST['image'];
                $chapters = [];
                foreach (explode(',', $_POST['chapter']) as $chapter) {
                    list($number, $title, $filePath) = explode(':', $chapter);
                    $chapters[] = new Chapter($number, $title, $filePath);
                }
                $rating = $_POST['rating'];
                $sinopsis = $_POST['sinopsis'];
                $background = $_POST['background'];
                $author = $_POST['author'];
                $freeSample = $_POST['freeSample'];
                $komikModel->updateKomik($idKomik, $judul, $penulis, $penerbit, $harga, $genre, $image, $chapters, $rating, $sinopsis, $background, $author, $freeSample);
                header('Location: index.php?modul=adminKomikManagement');
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
            header('Location: index.php?modul=adminKomikManagement');
            exit;

        case 'updateChapter':
            $id = $_GET['id'] ?? null;
            $chapterNumber = $_GET['chapter'] ?? null;
            if (!$id || !$chapterNumber) {
                die("ID komik atau nomor chapter tidak ditemukan.");
            }
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if (isset($_FILES['chapter_file']) && $_FILES['chapter_file']['error'] == UPLOAD_ERR_OK) {
                    $uploadDirChapter = __DIR__ . '/Assets/uploads/Chapters/';
                    $chapterFilePath = 'Assets/uploads/Chapters/' . basename($_FILES['chapter_file']['name']);
                    move_uploaded_file($_FILES['chapter_file']['tmp_name'], $uploadDirChapter . basename($_FILES['chapter_file']['name']));
                    $komikModel->updateChapterFile($id, $chapterNumber, $chapterFilePath);
                    header('Location: index.php?modul=komik&fitur=edit&id=' . $id);
                    exit;
                }
            }
            break;

        default:
            header('Location: index.php?modul=adminKomikManagement');
            break;
    }
}

function handleUser() {
    $fitur = $_GET['fitur'] ?? null;
    $userModel = new UserModel();

    switch ($fitur) {
        case 'add':
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $name = $_POST['name'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $hash_password = password_hash($password, PASSWORD_DEFAULT);
                $userModel->addUser(new User(null, $name, $email, $hash_password));
                header('Location: index.php?modul=user');
                exit;
            } else {
                include __DIR__ . '/view/user_input.php';
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
            include __DIR__ . '/view/aView/aUserUpdate.php';
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
                $saldo = $_POST['saldo'];
                $password = $_POST['password'];
                $hash_password = password_hash($password, PASSWORD_DEFAULT);
                $userModel->updateUser($idUser, $name, $email, $saldo, $hash_password);
                header('Location: index.php?modul=user');
                exit();
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
            include __DIR__ . '/view/aView/aUserManagement.php';
            break;
    }
}

function handleReadComic() {
    include __DIR__ . '/view/uReadComic.php';
}

function handleListKomik() {
    include __DIR__ . '/view/uListKomik.php';
}

function handleLibrary() {
    $userModel = new UserModel();
    $userModel->removeExpiredComics();
    include __DIR__ . '/view/uLibrary.php';
}

function handleHome() {
    include __DIR__ . '/view/uHome.php';
}

function handleDetailKomik() {
    $komikId = $_GET['id'] ?? null;
    if ($komikId) {
        include __DIR__ . '/view/uDetailkomik.php';
    } else {
        echo "Komik ID not provided.";
    }
}

function handleChapter() {
    include __DIR__ . '/view/uChapter.php';
}

function handleProfile() {
    include __DIR__ . '/view/uProfile.php';
}

function handleEditProfile() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $userModel = new UserModel();
        $user = $userModel->getUserById($_SESSION['user_id']);
        if ($user) {
            if (isset($_POST['topup']) && $_POST['topup'] == 'true') {
                $amount = $_POST['topup_amount'];
                $userModel->requestTopUp($user->userId, $amount);
                header('Location: index.php?modul=profile');
                exit();
            }

            $profilePicture = $_POST['existing_profile_picture'];
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
                $_POST['saldo'],
                $_POST['email'],
                $profilePicture,
                $_POST['password'] ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null
            );

            // Update session variables
            $_SESSION['username'] = $_POST['first_name'];
            $_SESSION['profile_picture'] = $profilePicture;

            header('Location: index.php?modul=profile');
            exit();
        } else {
            header('Location: index.php?modul=logout');
            exit();
        }
    }
    include __DIR__ . '/view/uEditProfileUser.php';
}

function handleBuyChapter() {
    $comicId = $_GET['id'] ?? null;
    $chapter = $_GET['chapter'] ?? null;
    if ($comicId && $chapter) {
        $komikModel = new KomikModel();
        $komik = $komikModel->getKomikById($comicId);
        if ($komik) {
            $price = $komik->harga; 
            $userModel = new UserModel();
            $userId = $_SESSION['user_id'];
            if ($userModel->purchaseComic($userId, $comicId, $chapter, $price)) {
                $userModel->addPurchasedChapter($userId, $comicId, $chapter);
                header('Location: index.php?modul=library');
            } else {
                echo "Saldo Kurang :(";
            }
        } else {
            echo "Comic not found.";
        }
    } else {
        echo "Comic ID or chapter not provided.";
    }
}

function handleFreeSample() {
    $komikId = $_GET['id'] ?? null;
    if ($komikId) {
        include __DIR__ . '/view/uFreeSample.php';
    } else {
        echo "Komik ID not provided.";
    }
}

function handleRentChapter() {
    $comicId = $_GET['id'] ?? null;
    $chapter = $_GET['chapter'] ?? null;
    if ($comicId && $chapter) {
        $komikModel = new KomikModel();
        $komik = $komikModel->getKomikById($comicId);
        if ($komik) {
            $price = $komik->harga * 0.5; // Use 50% of the comic's price for rental
            $userModel = new UserModel();
            $userId = $_SESSION['user_id'];
            if ($userModel->rentComic($userId, $comicId, $chapter, $price)) {
                header('Location: index.php?modul=library');
            } else {
                echo "Saldo Kurang :(";
            }
        } else {
            echo "Comic not found.";
        }
    } else {
        echo "Comic ID or chapter not provided.";
    }
}

function handleAdminKomikManagement() {
    include __DIR__ . '/view/aView/aKomikManagement.php';
}

function handleAdminAddBook() {
    include __DIR__ . '/view/aView/aMenambahBuku.php';
}

function handleAdminKeuanganManagement() {
    include __DIR__ . '/view/aView/aKeuanganManagement.php';
}

function handleListByGenre() {
    include __DIR__ . '/view/uListByGenre.php';
}

function handleDefault() {
    include __DIR__ . '/view/kosong.php';
}

switch ($modul) {
    case 'login':
        handleLogin();
        break;
    case 'register':
        handleRegister();
        break;
    case 'logout':
        handleLogout();
        break;
    case 'dashboard':
        handleDashboard();
        break;
    case 'adminHome':
        handleAdminHome();
        break;
    case 'komik':
        handleKomik();
        break;
    case 'user':
        handleUser();
        break;
    case 'readComic':
        handleReadComic();
        break;
    case 'listKomik':
        handleListKomik();
        break;
    case 'library':
        handleLibrary();
        break;
    case 'home':
        handleHome();
        break;
    case 'detailKomik':
        handleDetailKomik();
        break;
    case 'chapter':
        handleChapter();
        break;
    case 'profile':
        handleProfile();
        break;
    case 'editProfile':
        handleEditProfile();
        break;
    case 'buyChapter':
        handleBuyChapter();
        break;
    case 'freeSample':
        handleFreeSample();
        break;
    case 'rentChapter':
        handleRentChapter();
        break;
    case 'adminKomikManagement':
        handleAdminKomikManagement();
        break;
    case 'adminAddBook':
        handleAdminAddBook();
        break;
    case 'adminKeuanganManagement':
        handleAdminKeuanganManagement();
        break;
    case 'listByGenre':
        handleListByGenre();
        break;
    default:
        handleDefault();
        break;
}
?>
