<?php

namespace App\Model\Repository;

use App\Model\Entity\Advert;
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
        $stm = $db->prepare("SELECT * FROM adverts WHERE id = :id LIMIT 1");
        $stm->bindValue(':id', $id, PDO::PARAM_INT);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    public function create(array $advertData): Advert {
        $db               = $this->getDB();
        $id = $db->lastInsertId();  
        $advertData['id'] = $id;
        $stm = $db->prepare("INSERT INTO adverts VALUES (:id, :title, :description, :price)");
        $stm->execute($advertData);

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
        $host = '127.0.0.1';
        $db   = 'adverts';
        $user = 'root';
        $port = "3307";
        $pass = 'Miracle.1208';
        $charset = 'utf8mb4';

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset;port=$port";
        $pdo = new \PDO($dsn, $user, $pass, $options);
        
        return $pdo;
    }

}
