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

    public function getById(int $id): Advert | null
    {
        $ad = $this->getOneDB($id) ?? [];
        if (count($ad) === 0) {
            return null;
        }

        return new Advert($ad);
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
        $connection = AdvertDatabase::getConnection();
        $sql = $connection->query("SELECT * FROM adverts");
        $ads = $sql->fetchAll(\PDO::FETCH_ASSOC);

        return $ads ?? [];
    }

    private function getOneDB(int $id): array
    {
        $connection = AdvertDatabase::getConnection();
        $sql = $connection->query("SELECT * FROM adverts WHERE id = '$id'");
        $ad = $sql->fetch(\PDO::FETCH_ASSOC);
        if (!$ad) {
            return [];
        }

        return $ad;
    }

    private function saveDB(array $data):void
    {
        $connection = AdvertDatabase::getConnection();
        
        $adTitle = $data['title'];
        $adDescription = $data['description'];
        $adPrice = $data['price'];
        $result = $connection->query(
            "INSERT INTO adverts(title, description, price) 
            VALUES ('{$adTitle}', '{$adDescription}', '{$adPrice}')"
        );

        if ($result == false) {
            print("Произошла ошибка при выполнении запроса");
        }
    }

    private function updateDB(array $data):void
    {
        $connection = AdvertDatabase::getConnection();
        
        $adId = $data['id'];
        $adTitle = $data['title'];
        $adDescription = $data['description'];
        $adPrice = $data['price'];
        $result = $connection->query(
            "UPDATE adverts SET title = '{$adTitle}', description = '{$adDescription}', 
            price = '{$adPrice}' WHERE id = {$adId}"
        );

        if ($result == false) {
            print("Произошла ошибка при выполнении запроса");
        }
    }

    private function deleteDB(int $adId):void
    {
        $connection = AdvertDatabase::getConnection();
        $result = $connection->query(
            "DELETE FROM adverts WHERE id = {$adId}"
        );

        if ($result == false) {
            print("Произошла ошибка при выполнении запроса");
        }
    }
}
