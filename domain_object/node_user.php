<?php

class NodeUser {
    public $userId;
    public $name;
    public $email;
    public $password;

    public function __construct($userId, $name, $email, $password) {
        $this->userId = $userId;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }
}
?>