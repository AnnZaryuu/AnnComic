<?php
require_once __DIR__.'/../domain_object/node_komik.php';

class KomikModel {
    private $komikList = [];
    private $nextId = 1;

    public function __construct() {
        if (isset($_SESSION['komikList'])) {
            $this->komikList = unserialize($_SESSION['komikList']);
            $this->nextId = count($this->komikList) + 1;
        } else {
            $this->initializeDefaultKomik();
        }
    }

    public function initializeDefaultKomik() {
        $this->addKomik(new Komik($this->nextId++, 'Naruto', 'Masashi Kishimoto', 'Shueisha', 30000, 'Action'));
        $this->addKomik(new Komik($this->nextId++, 'One Piece', 'Eiichiro Oda', 'Shueisha', 35000, 'Adventure'));
        // Add more default komik as needed
    }

    public function addKomik(Komik $komik) {
        $this->komikList[] = $komik;
        $this->saveToSession();
    }

    private function saveToSession() {
        $_SESSION['komikList'] = serialize($this->komikList);
    }

    public function getKomikList() {
        return $this->komikList;
    }

    public function getKomikById($komikId) {
        foreach ($this->komikList as $komik) {
            if ($komik->id == $komikId) {
                return $komik;
            }
        }
        return null;
    }

    public function updateKomik($komikId, $judul, $penulis, $penerbit, $harga, $genre) {
        foreach ($this->komikList as $komik) {
            if ($komik->id == $komikId) {
                $komik->judul = $judul;
                $komik->penulis = $penulis;
                $komik->penerbit = $penerbit;
                $komik->harga = $harga;
                $komik->genre = $genre;
                $this->saveToSession();
                return true;
            }
        }
        return false;
    }

    public function deleteKomik($komikId) {
        foreach ($this->komikList as $key => $komik) {
            if ($komik->id == $komikId) {
                unset($this->komikList[$key]);
                $this->komikList = array_values($this->komikList); // Reindex array after deletion
                $this->saveToSession();
                return true;
            }
        }
        return false;
    }

    public function getKomikByName($name) {
        foreach ($this->komikList as $komik) {
            if ($komik->judul == $name) {
                return $komik;
            }
        }
        return null;
    }
}
?>
