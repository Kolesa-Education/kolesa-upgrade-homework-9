<?php

namespace App\Model\Repository;

use App\Model\Entity\Advert;
use PDO;

class AdvertRepository
{

    private const DB_PATH = './storage/adverts.json';

    public static $pdo;

   public function __construct(){
           $host = '127.0.0.1';
           $db = 'hw';
           $user = 'root';
           $pass = 'dilmurat26';
           $charset = 'utf8';

           $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
           $opt = [
               PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
               PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
               PDO::ATTR_EMULATE_PREPARES => false,
           ];
           try {
               self::$pdo = new PDO($dsn, $user, $pass, $opt);
           } catch (PDOException $e) {
               die('Подключение не удалось: ' . $e->getMessage());
           }

   }

    public function getAll()
    {
        $result = [];
        $stmt=self::$pdo->query('SELECT * FROM dbtable');
        $data=$stmt->fetchAll();

        foreach ($data as $advertData) {
            $result[] = new Advert($advertData);
        }

        return $result;
    }

    public function create(array $advertData): Advert
    {
        $db = $this->getDB();
        $title=$advertData['title'];
        $dscr=$advertData['description'];
        $price=$advertData['price'];

        $sql="insert into dbtable(title, description, price)values (?, ?, ?)";
        $stmt=$db->prepare($sql)->execute([$title, $dscr, $price]);

        return new Advert($advertData);
    }


    private function getDB()
    {
       return self::$pdo;
    }

//    private function saveDB(array $data): void
//    {
//        file_put_contents(self::DB_PATH, json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
//    }

    public function edit(array $advertData, int $id)
    {
        $db = $this->getDB();
        $title=$advertData['title'];
        $dscr=$advertData['description'];
        $price=$advertData['price'];

        $sql = "UPDATE dbtable SET title=?, description=?, price=? WHERE id=?";
        $db->prepare($sql)->execute([$title, $dscr, $price, $id]);
        return new Advert($advertData);
    }
}
