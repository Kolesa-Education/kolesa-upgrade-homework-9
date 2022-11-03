<?php

namespace App\Model\Repository;

use App\Model\Entity\Advert;
use App\Model\Repository\DB\DB;
use PDO;


class AdvertRepository
{
    private const DB_PATH = '../storage/adverts.json';

    public function getAll()
    {
        $result = [];

        foreach ($this->getDB() as $advertData) {
            $result[] = new Advert($advertData);
        }

        return $result;
    }

    public function getAdvert(int $id): Advert {
        $db = new DB();
        $connection = $db->connectDB();

        $statement = $connection->prepare('SELECT `title`, `description`, `price` FROM adverts WHERE `id` = ?');
        $statement->execute([$id]);
        $advertData = $statement->fetch();

        $advert = new Advert($advertData);

        return $advert;
    }

    public function create(array $advertData): Advert {
        $this->saveDB($advertData);

        return new Advert($advertData);
    }

    public function edit(array $advert, $id): void
    {
        $this->updateDB($advert, $id);
    }

    private function getDB(): array
    {
        $db = new DB();
        $connection = $db->connectDB();
        $adverts = $connection->query('SELECT * FROM adverts')->fetchAll(PDO::FETCH_ASSOC);
    
        return $adverts ?? [];
    }

    private function saveDB(array $data): void
    {
        $db = new DB();
        $connection = $db->connectDB();

        $statement = $connection->prepare('INSERT INTO adverts(title, description, price) VALUES (:title, :description, :price)');
        $statement->bindParam('title', $data['title']);
        $statement->bindParam('description', $data['description']);
        $statement->bindParam('price', $data['price']);
        $statement->execute();
    }

    private function updateDB(array $data, $id): void 
    {
        $db = new DB();
        $connection = $db->connectDB();

        $statement = $connection->prepare('UPDATE adverts SET `title` = :title, `description` = :description, `price` = :price WHERE `id` = :id');
        $statement->bindParam('title', $data['title']);
        $statement->bindParam('description', $data['description']);
        $statement->bindParam('price', $data['price']);
        $statement->bindParam('id', $id);
        $statement->execute();
    }
}
