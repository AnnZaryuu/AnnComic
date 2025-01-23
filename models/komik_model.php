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
        $this->komikList = [
            new Komik(2, 'Naruto', 'Masashi Kishimoto', 'Shueisha', 3000, ['Action', 'Adventure', 'Fantasy'], 'Assets/uploads/Poster book/Naruto.png', [
                new Chapter(1, 'Chapter 1', __DIR__ . '/../Assets/Comic/Manga/Naruto/Naruto_Chapter1.pdf'),
                new Chapter(2, 'Chapter 2', __DIR__ . '/../Assets/Comic/Manga/Naruto/Naruto_Chapter2.pdf'),
                new Chapter(3, 'Chapter 3', __DIR__ . '/../Assets/Comic/Manga/Naruto/Naruto_Chapter3.pdf')
            ], '9.0', 'Naruto Uzumaki, a young ninja who seeks recognition from his peers and dreams of becoming the Hokage, the leader of his village.', 'Assets/uploads/Poster landscape/Landscape Naruto.png', 'Assets/uploads/Authors/Masashi_Kishimoto.png', 'Assets/Comic/Manga/Naruto/Naruto_Sample.pdf'),
            
            new Komik(3, 'Tensei shitara Slime Datta Ken', 'Fuse', 'Shounen Sirius', 3000, ['Isekai', 'Reincarnation', 'Fantasy'], 'Assets/uploads/Poster book/Tensura.png', [
                new Chapter(1, 'Chapter 1', __DIR__ . '/../Assets/Comic/Manga/Tensura/Tensura_Chapter1.pdf'),
                new Chapter(2, 'Chapter 2', __DIR__ . '/../Assets/Comic/Manga/Tensura/Tensura_Chapter2.pdf'),
                new Chapter(3, 'Chapter 3', __DIR__ . '/../Assets/Comic/Manga/Tensura/Tensura_Chapter3.pdf'),
                new Chapter(4, 'Chapter 4', __DIR__ . '/../Assets/Comic/Manga/Tensura/Tensura_Chapter4.pdf')
            ], '8.37', 'Satoru Mikami, pekerja kantoran berusia 37 tahun, tewas setelah ditikam perampok di Tokyo. Ketika meninggal, ia mendengar suara misterius seperti AI. Saat tersadar, Satoru mendapati dirinya bereinkarnasi sebagai slime di sebuah gua aneh, dengan kemampuan menyerap dan meniru bentuk serta kemampuan apapun yang ia telan. Dalam penjelajahannya, ia bertemu naga raksasa bernama Veldora yang telah disegel selama 300 tahun. Setelah berteman dan berjanji membantu membebaskan Veldora, ia diberi nama baru: "Rimuru Tempest." Dengan tubuh dan kemampuan barunya, Rimuru memulai petualangan besar yang akan mengubah takdirnya dan dunia barunya.', 'Assets/uploads/Poster landscape/Tensura Landscape.png', 'Assets/uploads/Author/Default Photo.png', 'Assets/Sample/Tense.Shita.Slime.Datt.Ken Free Sampel.pdf'),
            
            new Komik(4, 'One Piece', 'Eiichiro Oda', 'Shueisha', 3500, ['Adventure', 'Action', 'Comedy'], 'Assets/uploads/Poster book/One Piece.png', [
                new Chapter(1, 'Chapter 1', __DIR__ . '/../Assets/Comic/Manga/OnePiece/OnePiece_Chapter1.pdf'),
                new Chapter(2, 'Chapter 2', __DIR__ . '/../Assets/Comic/Manga/OnePiece/OnePiece_Chapter2.pdf'),
                new Chapter(3, 'Chapter 3', __DIR__ . '/../Assets/Comic/Manga/OnePiece/OnePiece_Chapter3.pdf')
            ], '9.36', 'Monkey D. Luffy, a boy whose body gained the properties of rubber after unintentionally eating a Devil Fruit, sets off on a journey to find the One Piece and become the Pirate King.', 'Assets/uploads/Poster landscape/One_Piece_bg.png', 'Assets/uploads/Authors/Eiichiro_Oda.png', 'Assets/Comic/Manga/OnePiece/OnePiece_Sample.pdf'),
            
            new Komik(5, 'Attack on Titan', 'Hajime Isayama', 'Kodansha', 4000, ['Action', 'Drama', 'Fantasy'], 'Assets/uploads/Poster book/Attack on Titan.png', [
                new Chapter(1, 'Chapter 1', __DIR__ . '/../Assets/Comic/Manga/AttackOnTitan/AttackOnTitan_Chapter1.pdf'),
                new Chapter(2, 'Chapter 2', __DIR__ . '/../Assets/Comic/Manga/AttackOnTitan/AttackOnTitan_Chapter2.pdf'),
                new Chapter(3, 'Chapter 3', __DIR__ . '/../Assets/Comic/Manga/AttackOnTitan/AttackOnTitan_Chapter3.pdf')
            ], '9.5', 'Eren Yeager, his adoptive sister Mikasa Ackerman, and their friend Armin Arlert join the military to fight against the Titans after their hometown is destroyed and Eren\'s mother is killed.', 'Assets/uploads/Poster landscape/Shingeki no Kyojin.png', 'Assets/uploads/Author/Hajime_Isayama.png', 'Assets/Sample/AttackOnTitan_Sample.pdf'),
            
            new Komik(6, 'Vinland Saga', 'Yukimura Makoto', 'Afternoon', 4000, ['Action', 'Adventure', 'Historical'], 'Assets/uploads/Poster book/vindland saga poster 1.png', [
                new Chapter(1, 'Chapter 1', __DIR__ . '/../Assets/Comic/Manga/VinlandSaga/VinlandSaga_Chapter1.pdf'),
                new Chapter(2, 'Chapter 2', __DIR__ . '/../Assets/Comic/Manga/VinlandSaga/VinlandSaga_Chapter2.pdf'),
                new Chapter(3, 'Chapter 3', __DIR__ . '/../Assets/Comic/Manga/VinlandSaga/VinlandSaga_Chapter3.pdf'),
                new Chapter(4, 'Chapter 4', __DIR__ . '/../Assets/Comic/Manga/VinlandSaga/VinlandSaga_Chapter4.pdf'),
                new Chapter(5, 'Chapter 5', __DIR__ . '/../Assets/Comic/Manga/VinlandSaga/VinlandSaga_Chapter5.pdf')
            ], '9.08', 'Thorfinn tumbuh mendengarkan cerita tentang Vinland...', 'Assets/uploads/Poster landscape/Vinland_Saga_bg.png', 'Assets/uploads/Authors/Yukimura_Makoto.png', 'Assets/Comic/Manga/VinlandSaga/VinlandSaga_Sample.pdf'),
            
            new Komik(7, 'Solo Leveling ARISE Hunter Origin', 'Chugong', 'D&C Media', 4500, ['Fantasy', 'Action', 'Adventure'], 'Assets/uploads/Poster book/Solo Leveling.png', [
                new Chapter(1, 'Chapter 1', __DIR__ . '/../Assets/Comic/Manga/SoloLeveling/SoloLeveling_Chapter1.pdf'),
                new Chapter(2, 'Chapter 2', __DIR__ . '/../Assets/Comic/Manga/SoloLeveling/SoloLeveling_Chapter2.pdf'),
                new Chapter(3, 'Chapter 3', __DIR__ . '/../Assets/Comic/Manga/SoloLeveling/SoloLeveling_Chapter3.pdf')
            ], '9.36', 'menceritakan Jinwoo Sung, seorang Hunter lemah peringkat E, yang hidupnya berubah drastis setelah terjebak dalam dungeon mematikan dan menerima tawaran misterius dari "Sistem" yang memungkinkannya untuk naik level. Dengan kekuatan baru, Jinwoo perlahan menjadi Hunter terkuat, sambil mengungkap rahasia gelap di balik gerbang, monster, dan sistem itu sendiri. Perjalanan ini bukan hanya tentang kekuatan, tetapi juga tentang menemukan kebenaran dan takdirnya di dunia yang dipenuhi ancaman dan intrik.', 'Assets/uploads/Poster landscape/Solo_Leveling_bg.png', 'Assets/uploads/Author/Ki-Hong-Lee.png', 'Assets/Comic/Manga/SoloLeveling/SoloLeveling_Sample.pdf'),
            
            new Komik(8, 'Versatile Mage', 'Chaos', 'Qidian', 3000, ['Fantasy', 'Action', 'Adventure'], 'Assets/uploads/Poster book/Versatile Mage.png', [
                new Chapter(1, 'Chapter 1', __DIR__ . '/../Assets/Comic/Manga/VersatileMage/VersatileMage_Chapter1.pdf'),
                new Chapter(2, 'Chapter 2', __DIR__ . '/../Assets/Comic/Manga/VersatileMage/VersatileMage_Chapter2.pdf'),
                new Chapter(3, 'Chapter 3', __DIR__ . '/../Assets/Comic/Manga/VersatileMage/VersatileMage_Chapter3.pdf')
            ], '8.78', 'Mo Fan, seorang siswa yang menemukan bahwa dunia telah berubah menjadi dunia sihir dan dia memiliki kemampuan untuk mengendalikan elemen-elemen sihir.', 'Assets/uploads/Poster landscape/Versatile_Mage_bg.png', 'Assets/uploads/Authors/Chaos.png', 'Assets/Comic/Manga/VersatileMage/VersatileMage_Sample.pdf')
        ];
        // Add more default komik as needed
    }

    public function addKomik(Komik $komik) {
        // Assign ID 1 to the new comic
        $komik->id = 1;

        // Decrement the IDs of all existing comics by 1
        foreach ($this->komikList as $existingKomik) {
            $existingKomik->id++;
        }

        // Add the new comic to the beginning of the list
        array_unshift($this->komikList, $komik);

        $this->saveToSession();
    }

    public function deleteKomik($komikId) {
        foreach ($this->komikList as $key => $komik) {
            if ($komik->id == $komikId) {
                unset($this->komikList[$key]);
                $this->komikList = array_values($this->komikList); // Reindex array after deletion
                break;
            }
        }

        // Reassign IDs to the remaining comics
        foreach ($this->komikList as $index => $komik) {
            $komik->id = $index + 1;
        }

        $this->saveToSession();
    }

    public function updateChapterFile($komikId, $chapterNumber, $filePath) {
        foreach ($this->komikList as $komik) {
            if ($komik->id == $komikId) {
                foreach ($komik->chapters as $chapter) {
                    if ($chapter->number == $chapterNumber) {
                        $chapter->filePath = $filePath;
                        $this->saveToSession();
                        return true;
                    }
                }
            }
        }
        return false;
    }

    private function saveToSession() {
        $_SESSION['komikList'] = serialize($this->komikList);
    }

    public function getKomikList(): array {
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

    public function updateKomik($komikId, $judul, $penulis, $penerbit, $harga, $genre, $image, $chapters, $rating, $sinopsis, $background, $author, $freeSample) {
        foreach ($this->komikList as $komik) {
            if ($komik->id == $komikId) {
                $komik->judul = $judul;
                $komik->penulis = $penulis;
                $komik->penerbit = $penerbit;
                $komik->harga = $harga;
                $komik->genre = $genre;
                $komik->image = $image;
                $komik->chapters = $chapters;
                $komik->rating = $rating;
                $komik->sinopsis = $sinopsis;
                $komik->background = $background;
                $komik->author = $author;
                $komik->freeSample = $freeSample;
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

    public function fetchComics($sort) {
        $comics = $this->komikList;

        if ($sort == 'alphabet') {
            usort($comics, function($a, $b) {
                return strcmp($a->judul, $b->judul);
            });
        }

        return $comics;
    }

    public function getKomikByGenre($genre) {
        return array_filter($this->komikList, function($komik) use ($genre) {
            return in_array($genre, $komik->genre);
        });
    }
}
?>
