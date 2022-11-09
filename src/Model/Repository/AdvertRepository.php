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
        $stmt = $connection->prepare("SELECT * FROM adverts");
        $result = $stmt->execute();

        if (!$result) {
            return [];
        }

        $ads = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $ads;
    }

    private function getOneDB(int $id): array
    {
        $connection = AdvertDatabase::getConnection();
        $stmt = $connection->prepare("SELECT * FROM adverts WHERE id = ?");

        $result = $stmt->execute([$id]);
        if (!$result) {
            return [];
        }
        
        $ad = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $ad;
    }

    private function saveDB(array $data):void
    {        
        $adTitle = $data['title'];
        $adDescription = $data['description'];
        $adPrice = $data['price'];

        $connection = AdvertDatabase::getConnection();
        $stmt = $connection->prepare("INSERT INTO adverts(title, description, price) 
        VALUES (:title, :description, :price)");
        $stmt->bindParam(':title', $adTitle);
        $stmt->bindParam(':description', $adDescription);
        $stmt->bindParam(':price', $adPrice);

        $result = $stmt->execute();
        if (!$result) {
            print("Произошла ошибка при выполнении запроса");
        }
    }

    private function updateDB(array $data):void
    {        
        $adId = $data['id'];
        $adTitle = $data['title'];
        $adDescription = $data['description'];
        $adPrice = $data['price'];

        $connection = AdvertDatabase::getConnection();

        $stmt = $connection->prepare(
            "UPDATE adverts SET title = :title, description = :description, 
            price = :price WHERE id = :id"
        );

        $stmt->bindParam(':id', $adId);
        $stmt->bindParam(':title', $adTitle);
        $stmt->bindParam(':description', $adDescription);
        $stmt->bindParam(':price', $adPrice);

        $result = $stmt->execute();
        if (!$result) {
            print("Произошла ошибка при выполнении запроса");
        }
    }

    private function deleteDB(int $adId):void
    {
        $connection = AdvertDatabase::getConnection();
        
        $stmt = $connection->prepare(
            "DELETE FROM adverts WHERE id = :id"
        );
        $stmt->bindParam(':id', $adId);

        $result = $stmt->execute();
        if (!$result) {
            print("Произошла ошибка при выполнении запроса");
        }
    }
}
