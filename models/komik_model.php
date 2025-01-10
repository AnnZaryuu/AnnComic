<?php
require_once __DIR__.'/../domain_object/node_komik.php';

class KomikModel {
    private $komikList = [];
    private $nextId = 1;

    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['komikList'])) {
            $this->komikList = unserialize($_SESSION['komikList']);
            $this->nextId = count($this->komikList) + 1;
        } else {
            $this->initializeDefaultKomik();
        }
    }

    public function initializeDefaultKomik() {
        $this->addKomik(new Komik($this->nextId++, 'Naruto', 'Masashi Kishimoto', 'Shueisha', 30000, ['Action', 'Adventure', 'Fantasy'], '../Assets/Poster book/Naruto.png', ['Chapter 1', 'Chapter 2', 'Chapter 3'], '9.0', 'Naruto Uzumaki, a young ninja who seeks recognition from his peers and dreams of becoming the Hokage, the leader of his village.', '../Assets/Poster landscape/Landscape Naruto.png', '../Assets/Authors/Masashi_Kishimoto.png', '../Assets/Comic/Manga/Naruto/Naruto_Sample.pdf'));
        $this->addKomik(new Komik($this->nextId++, 'One Piece', 'Eiichiro Oda', 'Shueisha', 35000, ['Adventure', 'Action', 'Comedy'], '../Assets/Poster book/One Piece.png', ['Chapter 1', 'Chapter 2', 'Chapter 3'], '9.36', 'Monkey D. Luffy, a boy whose body gained the properties of rubber after unintentionally eating a Devil Fruit, sets off on a journey to find the One Piece and become the Pirate King.', '../Assets/Poster landscape/One_Piece_bg.png', '../Assets/Authors/Eiichiro_Oda.png', '../Assets/Comic/Manga/OnePiece/OnePiece_Sample.pdf'));
        $this->addKomik(new Komik($this->nextId++, 'Attack on Titan', 'Hajime Isayama', 'Kodansha', 40000, ['Action', 'Drama', 'Fantasy'], '../Assets/Poster book/Attack on Titan.png', ['Chapter 1', 'Chapter 2', 'Chapter 3'], '9.5', 'Eren Yeager, his adoptive sister Mikasa Ackerman, and their friend Armin Arlert join the military to fight against the Titans after their hometown is destroyed and Eren\'s mother is killed.', '../Assets/Poster landscape/Shingeki no Kyojin.png', '../Assets/Authors/Hajime_Isayama.png', '../Assets/Sample/AttackOnTitan_Sample.pdf'));
        $this->addKomik(new Komik($this->nextId++, 'Vinland Saga', 'Yukimura Makoto', 'Afternoon', 4000, ['Action', 'Adventure', 'Historical'], '../Assets/Poster book/vindland saga poster 1.png', ['Chapter 1', 'Chapter 2', 'Chapter 3'], '9.08', 'Thorfinn tumbuh mendengarkan cerita tentang Vinland...', '../Assets/Poster landscape/Vinland_Saga_bg.png', '../Assets/Authors/Yukimura_Makoto.png', '../Assets/Comic/Manga/VinlandSaga/VinlandSaga_Sample.pdf'));
        $this->addKomik(new Komik($this->nextId++, 'Solo Leveling', 'Chugong', 'D&C Media', 45000, ['Fantasy', 'Action', 'Adventure'], '../Assets/Poster book/Solo Leveling.png', ['Chapter 1', 'Chapter 2', 'Chapter 3'], '9.36', 'Sung Jin-Woo, seorang hunter lemah yang berubah menjadi hunter terkuat setelah menyelesaikan quest di dalam dungeon rahasia.', '../Assets/Poster landscape/Solo_Leveling_bg.png', '../Assets/Authors/Chugong.png', '../Assets/Comic/Manga/SoloLeveling/SoloLeveling_Sample.pdf'));
        $this->addKomik(new Komik($this->nextId++, 'Versatile Mage', 'Chaos', 'Qidian', 30000, ['Fantasy', 'Action', 'Adventure'], '../Assets/Poster book/Versatile Mage.png', ['Chapter 1', 'Chapter 2', 'Chapter 3'], '8.78', 'Mo Fan, seorang siswa yang menemukan bahwa dunia telah berubah menjadi dunia sihir dan dia memiliki kemampuan untuk mengendalikan elemen-elemen sihir.', '../Assets/Poster landscape/Versatile_Mage_bg.png', '../Assets/Authors/Chaos.png', '../Assets/Comic/Manga/VersatileMage/VersatileMage_Sample.pdf'));
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

    public function getRelatedKomik($genres) {
        $relatedKomik = [];
        foreach ($this->komikList as $komik) {
            if (array_intersect($komik->genre, $genres)) {
                $relatedKomik[] = $komik;
            }
        }
        return $relatedKomik;
    }
}
?>
