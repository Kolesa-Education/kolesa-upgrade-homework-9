<?php

namespace App\Model\Repository;

use App\Model\Entity\Advert;
use PDO;



class AdvertRepository
{
    //private const DB_PATH = '../storage/adverts.json';


    



    public function getAll()
    {
        /*
        $result = [];

        foreach ($this->getDB() as $advertData) {
            $result[] = new Advert($advertData);
        }

        return $result;*/

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
        /*$db               = $this->getDB();
        $increment        = array_key_last($db) + 1;
        $advertData['id'] = $increment;
        $db[$increment]   = $advertData;

        $this->saveDB($db);

        return new Advert($advertData);*/

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
        //return json_decode(file_get_contents(self::DB_PATH), true) ?? [];


        $host = 'localhost';
        $db   = 'ShopDB';
        $user = 'root';
        $pass = '123456';
        $charset = 'utf8';
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $opt = [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,PDO::ATTR_EMULATE_PREPARES => false];
        $pdo = new PDO($dsn, $user, $pass, $opt);
        return $pdo;
        

    }

    public function getAdvert($id) : Advert {
        $DB = $this->getAll();

        foreach ($DB as $el){
            if ($el->getId()==+$id){
                return $el;
            }
        }
        return new Advert();




        



    }


    public function setAdvert(array $advertData){
        /*
        $db    = $this->getDB();;
        $db[$advertData['id']]   = $advertData;

        $this->saveDB($db);

        return new Advert($advertData);*/

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



    /*
    private function saveDB(array $data):void
    {
        file_put_contents(self::DB_PATH, json_encode($data, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT));
    }*/





}
