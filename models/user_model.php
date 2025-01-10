<?php
require_once __DIR__ . '/../domain_object/node_user.php';

class UserModel {
    private $userList = [];
    private $nextId = 1;

    public function __construct() {
        if (isset($_SESSION['userList'])) {
            $this->userList = unserialize($_SESSION['userList']);
            $this->nextId = count($this->userList) + 1;
        } else {
            $this->initializeDefaultUsers();
        }
    }

    public function initializeDefaultUsers() {
        $this->addUser(new NodeUser($this->nextId++, 'John Doe', 'john@example.com', password_hash('password123', PASSWORD_DEFAULT), '', '', 100000, '../Assets/PhotoProfile/Ken Kaneki.png'));
        $this->addUser(new NodeUser($this->nextId++, 'AnnZaryuu', 'annzaryuu@gmail.com', password_hash('123', PASSWORD_DEFAULT), '', '', 50000, '../Assets/PhotoProfile/Thorfin Karlsefni.jpg'));
        $this->addUser(new NodeUser($this->nextId++, 'Jane Smith', 'jane@example.com', password_hash('password456', PASSWORD_DEFAULT), '', '', 75000, '../Assets/PhotoProfile/Ai Hoshino.png'));
        // Add more default users as needed
    }

    public function addUser(NodeUser $user) {
        $this->userList[] = $user;
        $this->saveToSession();
    }

    private function saveToSession() {
        $_SESSION['userList'] = serialize($this->userList);
    }

    public function getUserList() {
        return $this->userList;
    }

    public function getUserById($userId) {
        foreach ($this->userList as $user) {
            if ($user->userId == $userId) {
                return $user;
            }
        }
        return null;
    }

    public function updateUser($userId, $name, $email, $profession, $bio, $profilePicture = null, $password = null) {
        foreach ($this->userList as $user) {
            if ($user->userId == $userId) {
                $user->name = $name;
                $user->email = $email;
                $user->profession = $profession;
                $user->bio = $bio;
                if ($profilePicture) {
                    $user->profilePicture = $profilePicture;
                }
                if ($password) {
                    $user->password = password_hash($password, PASSWORD_DEFAULT);
                }
                $this->saveToSession();
                return true;
            }
        }
        return false;
    }

    public function deleteUser($userId) {
        foreach ($this->userList as $key => $user) {
            if ($user->userId == $userId) {
                unset($this->userList[$key]);
                $this->userList = array_values($this->userList); // Reindex array after deletion
                $this->saveToSession();
                return true;
            }
        }
        return false;
    }

    public function getUserByEmail($email) {
        foreach ($this->userList as $user) {
            if ($user->email == $email) {
                return $user;
            }
        }
        return null;
    }

    public function purchaseComic($userId, $comicId, $price) {
        foreach ($this->userList as $user) {
            if ($user->userId == $userId) {
                if ($user->saldo >= $price) {
                    $user->saldo -= $price;
                    if (!isset($user->purchasedComics)) {
                        $user->purchasedComics = [];
                    }
                    $user->purchasedComics[] = $comicId;
                    $this->saveToSession();
                    return true;
                } else {
                    return false; // Insufficient balance
                }
            }
        }
        return false; // User not found
    }

    public function getPurchasedComics($userId) {
        foreach ($this->userList as $user) {
            if ($user->userId == $userId) {
                return $user->purchasedComics ?? [];
            }
        }
        return [];
    }
}
?>
