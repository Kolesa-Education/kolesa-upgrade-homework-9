<?php

namespace App\Model\Repository;

use App\Model\Entity\Advert;
use PDO;
use PDOException;

class AdvertRepository
{

    private const DB_PATH = '../storage/adverts.json';

    public function getAll()
    {
        $conn = $this->getDB();
        $stmt = $conn->prepare("SELECT * FROM advert");
        $stmt->execute();
        $advert = $stmt->fetchAll();
        $result =[];
        foreach ($advert as $advertData){
            $result[] =new Advert($advertData);
        }
        return $result;


    }

    public function create(array $advertData){
        $title= $advertData['title'];
        $description = $advertData['description'];
        $price = $advertData['price'];
        $pdo = $this->getDB();
        //$sth = $pdo->query('SELECT * FROM advert');
        $sql = "INSERT INTO advert (title, description, price) VALUES (?,?,?)";
        $pdo->prepare($sql)->execute([$title, $description, $price]);
    }

    private function getDB(): PDO
    {
        //return json_decode(file_get_contents(self::DB_PATH), true) ?? [];
        try {
            $dbh = new PDO('mysql:host=localhost;dbname=adverts', 'root', '2001');
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage();
            die();
        }
        return $dbh;
    }

    private function saveDB(array $data):void
    {
        file_put_contents(self::DB_PATH, json_encode($data, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT));
    }

    public function getById(int $id): Advert
    {
        $adArray = $this->getDB();
        $stmt = $adArray->prepare("SELECT * FROM advert");
        $stmt->execute();
        $adverts = $stmt->fetchAll();
        foreach ($adverts as $advert){
            if ($advert['id']==$id){
                return new Advert($advert);
            }
        }
        return new Advert();

    }

    public function update(array $advertData,int $id){
        $title= $advertData['title'];
        $description = $advertData['description'];
        $price = $advertData['price'];
        $pdo = $this->getDB();
        //$sth = $pdo->query('SELECT * FROM advert');
        $sql = "UPDATE advert SET title = ?, description = ?, price = ? WHERE id=?";
        $pdo->prepare($sql)->execute(array($title, $description, $price,$id));

    }
}
