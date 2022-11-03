<?php

namespace App\Model\Repository;

use App\Model\Entity\Advert;
use PDO;


$connection = new PDO("mysql: host = localhost; dbname = advertDB", "asik", "Aru_010607");
class AdvertRepository {
    private function connectionDB(): PDO {
        $connection = new PDO("mysql: host = localhost; dbname = advertDB", "asik", "Aru_010607");
        return $connection;
    }

    public function getAll() {
        $result = [];
        $pdo = $this->connectionDB();
        $query = "SELECT * FROM advertDB.adverts";
        $data = $pdo->query($query)->fetchAll();

        foreach ($data as $advertData) {
            $result[] = new Advert($advertData);
        }
        return $result;
    }

    public function getById(int $id){
        $pdo = $this->connectionDB();
        $query = "SELECT id, title, description, price FROM advertDB.adverts WHERE id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute(array($id));

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return new Advert($data);
    }

    public function getId($id){

        $pdo = $this->connectionDB();
        $query = "SELECT id, title, description, price FROM advertDB.adverts WHERE id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute(array($id));

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        $result[] = new Advert($data);

        return $result;
    }

    public function edit(array $advertData){
        $pdo = $this->connectionDB();

        $id = $advertData['id'];
        $title = $advertData['title'];
        $description = $advertData['description'];
        $price = $advertData['price'];

        $stmt = $pdo->prepare('UPDATE advertDB.adverts
        SET title =?, description = ?, price = ? 
        WHERE id = ?');
        $stmt->execute(array($title, $description, $price, $id));
    }

    public function create(array $advertData): Advert{
        $pdo = $this->connectionDB();
        $advertData['id'] = $advertData['id']++;
        $title = $advertData['title'];
        $description = $advertData['description'];
        $price = $advertData['price'];

        $stmt = $pdo->prepare("INSERT INTO advertDB.adverts(title,description,price) 
        VALUES (?,?,?)");
        $stmt->execute(array($title,$description,$price));

        return new Advert($advertData);
    }

    // private const DB_PATH = '../storage/adverts.json';
    // public function deleteAdvert(array $advertData,$id): Advert {
    //     $pdo = $this->connectionDB();
    //     $db = $this->getDB();
    //     unset($advertData);
    //     $db[$id]   = $advertData;
    //     $this->saveDB($db);

    //     return new Advert($advertData);

    // }

    // private function saveDB(array $data):void
    // {
    //     file_put_contents(self::DB_PATH, json_encode($data, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT));
    // }

    // private function getDB(): array
    // {
    //     return json_decode(file_get_contents(self::DB_PATH), true) ?? [];
    // }
}