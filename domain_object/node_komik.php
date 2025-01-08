<?php

class Komik {
    public $id;
    public $judul;
    public $penulis;
    public $penerbit;
    public $harga;
    public $genre;

    public function __construct($id, $judul, $penulis, $penerbit, $harga, $genre) {
        $this->id = $id;
        $this->judul = $judul;
        $this->penulis = $penulis;
        $this->penerbit = $penerbit;
        $this->harga = $harga;
        $this->genre = $genre;
    }
}
?>