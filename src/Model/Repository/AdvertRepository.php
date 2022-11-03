<?php

namespace App\Model\Repository;

use App\Model\Entity\Advert;
use PDO;



class AdvertRepository
{
    private static PDO $pdo;

    public function __construct()
    {
        $host = 'localhost';
        $db   = 'ShopDB';
        $user = 'root';
        $pass = '123456';
        $charset = 'utf8';
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $opt = [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,PDO::ATTR_EMULATE_PREPARES => false];
        self::$pdo = new PDO($dsn, $user, $pass, $opt);
    }

    public function getAll()
    {

        $db = $this->getDB();
        $stmt = $db->query('SELECT * FROM Adverts');
        $dbArr= $stmt->fetchall();
        $result = [];
        foreach($dbArr as $advertData){
            $result[] = new Advert($advertData);
        }
        return $result;

    }

    public function create(array $advertData): Advert {

        $title = $advertData['title'];
        $description= $advertData['description'];
        $price = $advertData['price'];
        $category = $advertData['category'];

        $pdo = $this->getDB();

        $stmt = $pdo->prepare('insert into Adverts (title, description, price, category) values (?,?,?,?)');
        $stmt->execute(array($title, $description, $price,$category));



    }

    private function getDB(): array
    {
        return self::$pdo;
    }

    public function getAdvert($id) : Advert {
        $DB = $this->getAll();

        foreach ($DB as $el){
            if ($el->getId()==+$id){
                return $el;
            }
        }
        throw new Exception('No Advert');

    }


    public function setAdvert(array $advertData){


        $title = $advertData['title'];
        $description= $advertData['description'];
        $price = $advertData['price'];
        $category = $advertData['category'];
        $id = $advertData['id'];

        $db = $this->getDB();
        $stmt = $db->prepare('UPDATE Adverts
        SET title =?, description = ?, price = ?, category = ? 
        WHERE id = ?');
        $stmt->execute(array($title, $description, $price, $category ,$id));
    
    }

}
