<?php

namespace App\Model\Repository;

use App\Model\Entity\Advert;
use App\Infrastructure\Database\AdvertDatabase;

class AdvertRepository
{
    // private const DB_PATH = '../storage/adverts.json';

    public function getAll()
    {
        $result = [];

        foreach ($this->getDB() as $advertData) {
            $result[] = new Advert($advertData);
        }

        return $result;
    }

    public function getById(int $id): Advert
    {
        $adArray = $this->getDB();
        $advertData = $adArray[$id];
        
        return new Advert($advertData);
    }

    public function create(array $advertData): Advert {
        $this->saveDB($advertData);

        return new Advert($advertData);
    }

    public function edit(array $advertData): Advert {
        $this->saveDB($advertData);

        return new Advert($advertData);
    }

    private function getDB(): array
    {
        $pdo = AdvertDatabase::getConnection();
        $sql = $pdo::$connection->query("SELECT * FROM adverts");
        $ads = $sql->fetch(\PDO::FETCH_ASSOC);
        print_r($ads);

        return $ads ?? [];
    }

    private function saveDB(array $data):void
    {
        $pdo = AdvertDatabase::getConnection();
        
        $adTitle = $data['title'];
        $adDescription = $data['description'];
        $adPrice = $data['price'];
        $result = $pdo::$connection->query('INSERT INTO adverts(title, description, price) 
        VALUES ' . $adTitle . ', ' . $adDescription .', ' . $adPrice);
        if ($result == false) {
            print("Произошла ошибка при выполнении запроса");
        }
    }
}
