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
        $this->addUser(new NodeUser($this->nextId++, 'John Doe', 'john@example.com', password_hash('password123', PASSWORD_DEFAULT)));
        $this->addUser(new NodeUser($this->nextId++, 'Jane Smith', 'jane@example.com', password_hash('password456', PASSWORD_DEFAULT)));
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

    public function updateUser($userId, $name, $email, $password) {
        foreach ($this->userList as $user) {
            if ($user->userId == $userId) {
                $user->name = $name;
                $user->email = $email;
                $user->password = $password;
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
}
?>
