<?php
require_once __DIR__ . '/../domain_object/node_user.php';

interface UserRepositoryInterface {
    public function addUser(User $user): void;
    public function getUserById(int $userId): ?User;
    public function updateUser(int $userId, string $name, int $saldo, string $email, ?string $profilePicture, ?string $password): bool;
    public function deleteUser(int $userId): bool;
    public function getUserList(): array;
    public function getUserByEmail(string $email): ?User;
    public function purchaseComic(int $userId, int $comicId, int $chapter, float $price): bool;
    public function getPurchasedComics(int $userId): array;
    public function rentComic(int $userId, int $comicId, int $chapter, float $price): bool;
    public function getRentedComics(int $userId): array;
    public function requestTopUp(int $userId, float $amount): void;
    public function approveTopUp(int $userId, float $amount): bool;
}

class UserModel implements UserRepositoryInterface {
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

    private function initializeDefaultUsers(): void {
        $this->addUser(new User($this->nextId++, 'AnnZaryuu', 'anjar@gmail.com', password_hash('anjar', PASSWORD_DEFAULT), 10000, '../Assets/PhotoProfile/Thorfin Karlsefni.jpg'));
        $this->addUser(new User($this->nextId++, 'User2', 'user2@example.com', password_hash('user123', PASSWORD_DEFAULT), 2000, 'path/to/profile2.png'));
    }

    public function addUser(User $user): void {
        $this->userList[] = $user;
        $this->saveToSession();
    }

    public function getUserById(int $userId): ?User {
        foreach ($this->userList as $user) {
            if ($user->userId == $userId) {
                return $user;
            }
        }
        return null;
    }

    public function updateUser(int $userId, string $name, int $saldo, string $email, ?string $profilePicture, ?string $password): bool {
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

    public function deleteUser(int $userId): bool {
        foreach ($this->userList as $key => $user) {
            if ($user->userId == $userId) {
                unset($this->userList[$key]);
                $this->userList = array_values($this->userList);
                $this->saveToSession();
                return true;
            }
        }
        return false;
    }

    public function getUserList(): array {
        return $this->userList;
    }

    public function getUserByEmail(string $email): ?User {
        foreach ($this->userList as $user) {
            if ($user->email == $email) {
                return $user;
            }
        }
        return null;
    }

    public function purchaseComic(int $userId, int $comicId, int $chapter, float $price): bool {
        $user = $this->getUserById($userId);
        if ($user && $user->saldo >= $price) {
            $user->saldo -= $price;
            if (!isset($user->purchasedComics)) {
                $user->purchasedComics = [];
            }
            $user->purchasedComics[$comicId][$chapter] = true;
            $this->saveToSession();
            return true;
        }
        return false;
    }

    public function getPurchasedComics(int $userId): array {
        $user = $this->getUserById($userId);
        return $user ? ($user->purchasedComics ?? []) : [];
    }

    public function rentComic(int $userId, int $comicId, int $chapter, float $price): bool {
        $user = $this->getUserById($userId);
        if ($user && $user->saldo >= $price) {
            $user->saldo -= $price;
            $expiryDate = date('Y-m-d H:i:s', strtotime('+3 days'));
            if (!isset($user->rentedComics)) {
                $user->rentedComics = [];
            }
            $user->rentedComics[$comicId][$chapter] = $expiryDate;
            $this->saveToSession();
            return true;
        }
        return false;
    }

    public function getRentedComics(int $userId): array {
        $user = $this->getUserById($userId);
        return $user ? ($user->rentedComics ?? []) : [];
    }

    public function requestTopUp(int $userId, float $amount): void {
        if (!isset($_SESSION['topUpRequests'])) {
            $_SESSION['topUpRequests'] = [];
        }
        $_SESSION['topUpRequests'][] = ['userId' => $userId, 'amount' => $amount];
    }

    public function approveTopUp(int $userId, float $amount): bool {
        $user = $this->getUserById($userId);
        if ($user) {
            $user->saldo += $amount;
            $this->saveToSession();
            return true;
        }
        return false;
    }

    private function saveToSession(): void {
        $_SESSION['userList'] = serialize($this->userList);
    }
}
?>
