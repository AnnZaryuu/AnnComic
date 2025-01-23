<?php

class NodeUser {
    public $userId;
    public $name;
    public $email;
    public $password;
    public $profilePicture;

    public function __construct($userId, $name, $email, $password, $profilePicture = '') {
        $this->userId = $userId;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->profilePicture = $profilePicture;
    }
}

class User extends NodeUser {
    public $saldo;
    public $purchasedComics;
    public $rentedComics;

    public function __construct($userId, $name, $email, $password, $saldo = 0, $profilePicture = '') {
        parent::__construct($userId, $name, $email, $password, $profilePicture);
        $this->saldo = $saldo;
        $this->purchasedComics = [];
        $this->rentedComics = [];
    }
}
?>