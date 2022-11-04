<?php

namespace App\Model\Repository;

use App\Model\Entity\Advert;
use PDO;

class AdvertRepository
{
    protected $pdo = null;

    public function connectDB()
    {
        $host = 'localhost';
        $data = 'advertsdb';
        $user = 'root';
        $pass = 'root';
        $attr = "mysql:host=$host;dbname=$data";

        if (is_null($this->pdo)) {
            try {
                $this->pdo = new PDO($attr, $user, $pass);
        }
        catch (\PDOException $e)
        {
            throw new \PDOException($e->getMessage());
        }


            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        }
        return $this->pdo;
    }

    public function getAll()
    {
        $result = [];
        foreach ($this->getDB() as $advertData) {
            $result[] = new Advert($advertData);
        }

        return $result;
    }

    public function getAdvert(int $id): Advert {
        $connection = $this->connectDB();
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
        $connection = $this->connectDB();
        $adverts = $connection->query('SELECT * FROM adverts')->fetchAll(PDO::FETCH_ASSOC);

        return $adverts ?? [];
    }

    private function saveDB(array $data): void
    {
        $connection = $this->connectDB();
        $statement = $connection->prepare('INSERT INTO adverts(title, description, price) VALUES (:title, :category, :description, :price)');
        $statement->bindParam('title', $data['title']);
        $statement->bindParam('description', $data['description']);
        $statement->bindParam('price', $data['price']);
        $statement->execute();
    }

    private function updateDB(array $data, $id): void
    {
        $connection = $this->connectDB();
        $statement = $connection->prepare('UPDATE adverts SET `title` = :title, `description` = :description, `price` = :price WHERE `id` = :id');
        $statement->bindParam('id', $id);
        $statement->bindParam('title', $data['title']);
        $statement->bindParam('description', $data['description']);
        $statement->bindParam('price', $data['price']);
        $statement->execute();
    }
}