<?php

class Komik {
    public $id;
    public $judul;
    public $penulis;
    public $penerbit;
    public $harga;
    public $genre = [];
    public $image;
    public $chapter = [];
    public $rating;
    public $sinopsis;
    public $background;
    public $author;
    public $freeSample;

    public function __construct($id, $judul, $penulis, $penerbit, $harga, $genre, $image, $chapter, $rating, $sinopsis, $background, $author, $freeSample) {
        $this->id = $id;
        $this->judul = $judul;
        $this->penulis = $penulis;
        $this->penerbit = $penerbit;
        $this->harga = $harga;
        $this->genre = $genre;
        $this->image = $image;
        $this->chapter = $chapter;
        $this->rating = $rating;
        $this->sinopsis = $sinopsis;
        $this->background = $background;
        $this->author = $author;
        $this->freeSample = $freeSample;
    }
}
?>