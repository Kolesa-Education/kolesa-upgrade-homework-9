<?php

namespace App\Model\Repository;

use App\Model\Entity\Advert;
use PDO;

class AdvertRepository extends Dbh
{
    private const DB_PATH = '../storage/adverts.json';

    public function getAll()
    {
        $result = [];

        $stmt = $this->connect()->query('SELECT title FROM adverts;');
        $query = $stmt->fetchAll(PDO::FETCH_DEFAULT);

        foreach ($query as $advertData) {
            $result[] = new Advert(json_decode(json_encode($advertData), true));
        }

        return $result;
    }

    public function read(int $id)
    {
        $stmt = $this->connect()->prepare('SELECT * FROM adverts WHERE id = :id;');

        $stmt->bindValue("id", $id);
        $stmt->execute();

        $query = $stmt->fetch(PDO::FETCH_DEFAULT);
        
        return new Advert(json_decode(json_encode($query), true));
    }

    public function create(array $advertData)
    {
        $stmt = $this->connect()->prepare('INSERT INTO adverts (title, description, price) VALUES (:title, :description, :price);');

        $stmt->bindValue("title", $advertData['title'], PDO::PARAM_STR);
        $stmt->bindValue("description", $advertData['description'], PDO::PARAM_STR);
        $stmt->bindValue("price", $advertData['price'], PDO::PARAM_INT);
        
        $stmt->execute();

        return new Advert($advertData);

    }

    public function update(int $id, array $advertData)
    {
        $stmt = $this->connect()->prepare('UPDATE adverts SET title = :title, description = :description, price = :price WHERE id = :id;');

        $stmt->bindValue("title", $advertData['title'], PDO::PARAM_STR);
        $stmt->bindValue("description", $advertData['description'], PDO::PARAM_STR);
        $stmt->bindValue("price", $advertData['price'], PDO::PARAM_INT);
        $stmt->bindValue("id", $advertData['id'], PDO::PARAM_INT);
        
        $stmt->execute();

        return new Advert($id, $advertData);
    }

    /*
    public function create(array $advertData): Advert 
    {
        $db               = $this->getDB();
        $increment        = array_key_last($db) + 1;
        $advertData['id'] = $increment;
        $db[$increment]   = $advertData;

        $this->saveDB($db);

        return new Advert($advertData);
    }

    public function read(int $id): Advert
    {
        $db = $this->getDB();
        $advertData = $db[$id];
        
        return new Advert($advertData);
    }

    public function update(array $advertData): Advert 
    {
        $db            = $this->getDB();
        $advertId      = $advertData[$id];
        $advertData    = $db[$advertId];
        
        $this->saveDB($db);

        return new Advert($advertData);
    }

    private function getDB(): array
    {
        return json_decode(file_get_contents(self::DB_PATH), true) ?? [];
    }

    private function saveDB(array $data): void
    {
        file_put_contents(self::DB_PATH, json_encode($data, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT));
    }
*/
}
