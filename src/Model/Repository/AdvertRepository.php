<?php

namespace App\Model\Repository;

use App\Model\Entity\Advert;
use PDO;

$connection = new PDO("mysql:host=localhost;dbname=adverts_db","root","zhanarys");
class AdvertRepository
{
    private const DB_PATH = '../storage/adverts.json';

    /*
     * OLD METHOD
    public function getAll()
    {
        $result = [];

        foreach ($this->getDB() as $advertData) {
            $result[] = new Advert($advertData);
        }

        return $result;
    }
    */

    private function connectDB(): PDO
    {
        $connection = new PDO("mysql:host=localhost;dbname=adverts_db","root","zhanarys");
        return $connection;
    }


    //METHOD FOR MYSQL
    public function getAll(){
        $pdo = $this->connectDB();
        $query = "SELECT * FROM adverts";
        $data = $pdo->query($query)->fetchAll();

        $result = [];

        foreach ($data as $advertData){
            $result[] = new Advert($advertData);
        }

        return $result;
    }

    /*
     * OLD METHOD
    public function getById(int $id): ?Advert{
        $adverts = $this->getDB();
        for ($i=0; $i<=count($adverts); $i++){
            if ($adverts[$i]['id'] == $id){
                return new Advert($adverts[$i]);
            }
        }
        return null;
    }
    */

    //METHOD FOR MYSQL
    public function getById(int $id){
        $pdo = $this->connectDB();
        $query = "SELECT id, title, description, price FROM adverts WHERE id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute(array($id));

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return new Advert($data);
    }

    //METHOD FOR MYSQL
    public function getViewId($id){

        $pdo = $this->connectDB();
        $query = "SELECT id, title, description, price FROM adverts WHERE id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute(array($id));

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        $result[] = new Advert($data);

        return $result;
    }


    /*
     * OLD METHOD
    public function getViewId($id)
    {
        $result = [];

        foreach ($this->getDB() as $advertData) {
            if ((int) $id==$advertData['id'])
            {
                $result[] = new Advert($advertData);
            }
        }

        return $result;
    }
    */

    public function edit(array $advertData): Advert {
        $db = $this->getDB();
        $db[$advertData['id']] = $advertData;

        $this->saveDB($db);

        return new Advert($advertData);
    }

    public function create(array $advertData): Advert {
        $db               = $this->getDB();
        $increment        = array_key_last($db) + 1;
        $advertData['id'] = $increment;
        $db[$increment]   = $advertData;

        $this->saveDB($db);

        return new Advert($advertData);
    }

    private function getDB(): array
    {
        return json_decode(file_get_contents(self::DB_PATH), true) ?? [];
    }

    private function saveDB(array $data):void
    {
        file_put_contents(self::DB_PATH, json_encode($data, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT));
    }
}
