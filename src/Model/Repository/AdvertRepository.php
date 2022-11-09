<?php

namespace App\Model\Repository;

use App\Model\Entity\Advert;
use App\Model\Entity\DatabaseConnection;
use PDO;
use PDOStatement;

class AdvertRepository
{
    private const DB_PATH = '../storage/adverts.json';

    public function getAll()
    {
        $result = [];

        foreach ($this->getDB()->query('SELECT * FROM adverts') as $advertData) {
            $result[] = new Advert($advertData);
        }

        return $result;
    }

    public function getById(int $id)
    {
        $db = $this->getDB();
        $stm = $db->prepare("SELECT * FROM adverts WHERE id = :id");
        $stm->bindValue(':id', $id, PDO::PARAM_INT);
        $stm->execute();
        $advert = new Advert($stm->fetch(PDO::FETCH_ASSOC));

        return $advert;
    }

    public function create(array $advertData): Advert {
        $db               = $this->getDB();
        $stm = $db->prepare("INSERT INTO adverts (title, description, price) VALUES (:title, :description, :price)");
        $stm->execute([$advertData["title"], $advertData["description"], $advertData["price"]]);

        return new Advert($advertData);
    }

    public function modify(array $advertData, int $id): Advert {
        $db               = $this->getDB();
        $advertData['id'] = $id;
        $stm = $db->prepare("UPDATE adverts SET title = :title, description = :description, price = :price WHERE id = :id");
        $stm->execute($advertData);


        return new Advert($advertData);
    }

    private function getDB()
    {
        $instance = DatabaseConnection::getInstance();
        return $instance->getConnection();
    }

}
