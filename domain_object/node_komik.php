<?php

class Komik{
    private $judul;
    private $penulis;
    private $penerbit;
    private $harga;
    private $genre;

    public function __construct($judul, $penulis, $penerbit, $harga, $genre){
        $this->judul = $judul;
        $this->penulis = $penulis;
        $this->penerbit = $penerbit;
        $this->harga = $harga;
        $this->genre = $genre;
    }

}
