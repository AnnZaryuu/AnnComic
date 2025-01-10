<?php

class NodeUser {
    public $userId;
    public $name;
    public $email;
    public $password;
    public $profession;
    public $bio;
    public $saldo;
    public $profilePicture;

    public function __construct($userId, $name, $email, $password, $profession = '', $bio = '', $saldo = 0, $profilePicture = '') {
        $this->userId = $userId;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->profession = $profession;
        $this->bio = $bio;
        $this->saldo = $saldo;
        $this->profilePicture = $profilePicture;
    }
}
?>