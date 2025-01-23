<?php
require_once __DIR__ . '/../domain_object/node_user.php';

class UserModel {
    private $userList = [];
    private $nextId = 1;

    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['userList'])) {
            $this->userList = unserialize($_SESSION['userList']);
            $this->nextId = count($this->userList) + 1;
        } else {
            $this->initializeDefaultUsers();
        }
    }

    public function initializeDefaultUsers() {
        $this->addUser(new User($this->nextId++, 'AnnZaryuu', 'anjar@gmail.com', password_hash('anjar', PASSWORD_DEFAULT), 10000, '../Assets/PhotoProfile/Thorfin Karlsefni.jpg'));
        $this->addUser(new User($this->nextId++, 'User2', 'user2@example.com', password_hash('user123', PASSWORD_DEFAULT), 2000, 'path/to/profile2.png'));
        // Add more default users as needed
    }

    public function addUser(User $user) {
        $this->userList[] = $user;
        $this->saveToSession();
    }

    private function saveToSession() {
        $_SESSION['userList'] = serialize($this->userList);
    }

    public function getUserList(): array {
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

    public function updateUser($userId, $name,$saldo , $email, $profilePicture = null, $password = null) {
        foreach ($this->userList as $user) {
            if ($user->userId == $userId) {
                $user->name = $name;
                $user->email = $email;
                $user->saldo = $saldo;
                if ($profilePicture) {
                    $user->profilePicture = $profilePicture;
                }
                if ($password) {
                    $user->password = $password;
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

    public function purchaseComic($userId, $comicId, $chapter, $price) {
        foreach ($this->userList as $user) {
            if ($user->userId == $userId) {
                if ($user->saldo >= $price) {
                    $user->saldo -= $price;
                    if (!isset($user->purchasedComics)) {
                        $user->purchasedComics = [];
                    }
                    $user->purchasedComics[$comicId][$chapter] = true;
                    $this->saveToSession();
                    return true;
                } else {
                    return false;
                }
            }
        }
        return false; // User not found
    }

    public function getPurchasedComics($userId) {
        foreach ($this->userList as $user) {
            if ($user->userId == $userId) {
                return $user->purchasedComics;
            }
        }
        return [];
    }

    public function requestTopUp($userId, $amount) {
        // Save the top-up request to the session or database
        if (!isset($_SESSION['topUpRequests'])) {
            $_SESSION['topUpRequests'] = [];
        }
        $_SESSION['topUpRequests'][] = ['userId' => $userId, 'amount' => $amount];
    }

    public function approveTopUp($userId, $amount) {
        foreach ($this->userList as $user) {
            if ($user->userId == $userId) {
                $user->saldo += $amount;
                $this->saveToSession();
                return true;
            }
        }
        return false;
    }

    public function rentComic($userId, $comicId, $chapter, $price) {
        $user = $this->getUserById($userId);
        if ($user && $user->saldo >= $price) {
            $newSaldo = $user->saldo - $price;
            $this->updateUserSaldo($userId, $newSaldo);

            $expiryDate = date('Y-m-d H:i:s', strtotime('+3 days'));
            $this->addComicToLibrary($userId, $comicId, $chapter, $expiryDate);

            return true;
        }
        return false;
    }

    private function updateUserSaldo($userId, $newSaldo) {
        foreach ($this->userList as $user) {
            if ($user->userId == $userId) {
                $user->saldo = $newSaldo;
                $this->saveToSession();
                return true;
            }
        }
        return false;
    }

    private function addComicToLibrary($userId, $comicId, $chapter, $expiryDate) {
        foreach ($this->userList as $user) {
            if ($user->userId == $userId) {
                if (!isset($user->rentedComics)) {
                    $user->rentedComics = [];
                }
                $user->rentedComics[$comicId][$chapter] = $expiryDate;
                $this->saveToSession();
                return true;
            }
        }
        return false;
    }

    public function removeExpiredComics() {
        $currentDate = date('Y-m-d H:i:s');
        foreach ($this->userList as $user) {
            if (isset($user->rentedComics)) {
                foreach ($user->rentedComics as $comicId => $chapters) {
                    foreach ($chapters as $chapter => $expiryDate) {
                        if ($expiryDate < $currentDate) {
                            unset($user->rentedComics[$comicId][$chapter]);
                        }
                    }
                }
            }
        }
        $this->saveToSession();
    }

    public function isComicInLibrary($userId, $comicId) {
        $user = $this->getUserById($userId);
        if ($user && isset($user->rentedComics) && array_key_exists($comicId, $user->rentedComics)) {
            return true;
        }
        return false;
    }

    public function getRentedComics($userId) {
        foreach ($this->userList as $user) {
            if ($user->userId == $userId) {
                return $user->rentedComics;
            }
        }
        return [];
    }

    public function addPurchasedChapter($userId, $comicId, $chapter) {
        $purchasedComics = $this->getPurchasedComics($userId);
        if (!isset($purchasedComics[$comicId])) {
            $purchasedComics[$comicId] = [];
        }
        $purchasedComics[$comicId][$chapter] = true;
        $this->savePurchasedComics($userId, $purchasedComics);
    }

    private function savePurchasedComics($userId, $purchasedComics) {
        foreach ($this->userList as $user) {
            if ($user->userId == $userId) {
                $user->purchasedComics = $purchasedComics;
                $this->saveToSession();
                return true;
            }
        }
        return false;
    }
}
?>
