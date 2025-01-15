<?php

class Chapter {
    public $number;
    public $title;
    public $filePath;

    public function __construct($number, $title, $filePath) {
        $this->number = $number;
        $this->title = $title;
        $this->filePath = $filePath;
    }
}

class Komik {
    public $id;
    public $judul;
    public $penulis;
    public $penerbit;
    public $harga;
    public $genre = [];
    public $image;
    public $chapters = [];
    public $rating;
    public $sinopsis;
    public $background;
    public $author;
    public $freeSample;

    public function __construct($id, $judul, $penulis, $penerbit, $harga, $genre, $image, $chapters, $rating, $sinopsis, $background, $author, $freeSample) {
        $this->id = $id;
        $this->judul = $judul;
        $this->penulis = $penulis;
        $this->penerbit = $penerbit;
        $this->harga = $harga;
        $this->genre = $genre;
        $this->image = $image;
        $this->chapters = $chapters;
        $this->rating = $rating;
        $this->sinopsis = $sinopsis;
        $this->background = $background;
        $this->author = $author;
        $this->freeSample = $freeSample;
    }
}
?>