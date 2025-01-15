<?php
require_once __DIR__ . '/../domain_object/node_admin.php';
require_once __DIR__ . '/../models/komik_model.php';
require_once __DIR__ . '/../models/user_model.php';

class AdminModel {
    private $adminList = [];
    private $nextId = 1;
    private $komikModel;
    private $userModel;

    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $this->komikModel = new KomikModel();
        $this->userModel = new UserModel();

        if (isset($_SESSION['adminList'])) {
            $this->adminList = unserialize($_SESSION['adminList']);
            $this->nextId = count($this->adminList) + 1;
        } else {
            $this->initializeDefaultAdmins();
        }
    }

    public function initializeDefaultAdmins() {
        $this->addAdmin(new NodeAdmin($this->nextId++, 'Admin', 'admin@example.com', password_hash('admin123', PASSWORD_DEFAULT), 'admin'));
        // Add more default admins as needed
    }

    public function addAdmin(NodeAdmin $admin) {
        $this->adminList[] = $admin;
        $this->saveToSession();
    }

    private function saveToSession() {
        $_SESSION['adminList'] = serialize($this->adminList);
    }

    public function getAdminList(): array {
        return $this->adminList ?? [];
    }

    public function getAdminById($adminId) {
        foreach ($this->adminList as $admin) {
            if ($admin->id_admin == $adminId) {
                return $admin;
            }
        }
        return null;
    }

    public function getAdminByEmail($email) {
        foreach ($this->adminList as $admin) {
            if ($admin->email == $email) {
                return $admin;
            }
        }
        return null;
    }

    public function updateAdmin($adminId, $name, $email, $role, $password = null) {
        foreach ($this->adminList as $admin) {
            if ($admin->id_admin == $adminId) {
                $admin->nama = $name;
                $admin->email = $email;
                $admin->role = $role;
                if ($password) {
                    $admin->password = password_hash($password, PASSWORD_DEFAULT);
                }
                $this->saveToSession();
                return true;
            }
        }
        return false;
    }

    public function deleteAdmin($adminId) {
        foreach ($this->adminList as $key => $admin) {
            if ($admin->id_admin == $adminId) {
                unset($this->adminList[$key]);
                $this->adminList = array_values($this->adminList); // Reindex array after deletion
                $this->saveToSession();
                return true;
            }
        }
        return false;
    }

    // Komik Management
    public function addKomik(Komik $komik) {
        return $this->komikModel->addKomik($komik);
    }

    public function updateKomik($komikId, $judul, $penulis, $penerbit, $harga, $genre, $image, $chapters, $rating, $sinopsis, $background, $author, $freeSample) {
        return $this->komikModel->updateKomik($komikId, $judul, $penulis, $penerbit, $harga, $genre, $image, $chapters, $rating, $sinopsis, $background, $author, $freeSample);
    }

    public function deleteKomik($komikId) {
        return $this->komikModel->deleteKomik($komikId);
    }

    public function getKomikList(): array {
        return $this->komikModel->getKomikList();
    }

    public function getKomikById($komikId) {
        return $this->komikModel->getKomikById($komikId);
    }

    // User Management
    public function addUser(User $user) {
        return $this->userModel->addUser($user);
    }

    public function updateUser($userId, $name, $email, $saldo, $profilePicture = null, $password = null) {
        return $this->userModel->updateUser($userId, $name, $email, $saldo, $profilePicture, $password);
    }

    public function deleteUser($userId) {
        return $this->userModel->deleteUser($userId);
    }

    public function getUserList(): array {
        return $this->userModel->getUserList();
    }

    public function getUserById($userId) {
        return $this->userModel->getUserById($userId);
    }
}
?>
