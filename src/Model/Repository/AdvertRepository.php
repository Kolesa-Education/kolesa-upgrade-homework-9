<?php

namespace App\Model\Repository;

use App\Model\Entity\Advert;
use App\Infrastructure\Database\AdvertDatabase;

class AdvertRepository
{
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
        foreach ($adArray as $ad) {
            if ($ad['id'] == $id) {
                return new Advert($ad);
            }
        }
        
        return new Advert;
    }

    public function create(array $advertData): Advert {
        $this->saveDB($advertData);

        return new Advert($advertData);
    }

    public function edit(array $advertData): Advert {
        $this->updateDB($advertData);

        return new Advert($advertData);
    }

    public function delete(int $adId):void 
    {
        $this->deleteDB($adId);
    }

    private function getDB(): array
    {
        $pdo = AdvertDatabase::getConnection();
        $sql = $pdo::$connection->query("SELECT * FROM adverts");
        $ads = $sql->fetchAll(\PDO::FETCH_ASSOC);

        return $ads ?? [];
    }

    private function saveDB(array $data):void
    {
        $pdo = AdvertDatabase::getConnection();
        
        $adTitle = $data['title'];
        $adDescription = $data['description'];
        $adPrice = $data['price'];
        $result = $pdo::$connection->query(
            "INSERT INTO adverts(title, description, price) 
            VALUES ('{$adTitle}', '{$adDescription}', '{$adPrice}')"
        );

        if ($result == false) {
            print("Произошла ошибка при выполнении запроса");
        }
    }

    private function updateDB(array $data):void
    {
        $pdo = AdvertDatabase::getConnection();
        
        $adId = $data['id'];
        $adTitle = $data['title'];
        $adDescription = $data['description'];
        $adPrice = $data['price'];
        $result = $pdo::$connection->query(
            "UPDATE adverts SET title = '{$adTitle}', description = '{$adDescription}', 
            price = '{$adPrice}' WHERE id = {$adId}"
        );

        if ($result == false) {
            print("Произошла ошибка при выполнении запроса");
        }
    }

    private function deleteDB(int $adId):void
    {
        $pdo = AdvertDatabase::getConnection();
        $result = $pdo::$connection->query(
            "DELETE FROM adverts WHERE id = {$adId}"
        );

        if ($result == false) {
            print("Произошла ошибка при выполнении запроса");
        }
    }
}
