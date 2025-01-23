
<?php

class NodeAdmin {

    public $id_admin;

    public $nama;

    public $email;

    public $password;

    public $role;



    public function __construct($id_admin, $nama, $email, $password, $role) {

        $this->id_admin = $id_admin;

        $this->nama = $nama;

        $this->email = $email;

        $this->password = $password;

        $this->role = $role;

    }

}
