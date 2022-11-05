<?php

namespace App\Model\Repository;

use App\Model\Entity\Advert;
use PDO;
use PDOStatement;

class AdvertRepository
{
    private const DB_PATH = '../storage/adverts.json';

    private function getDB()
    {
        $host = '127.0.0.1';
        $db   = 'advertDB';
        $user = 'root';
        $port = "3306";
        $pass = '';
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

    public function getAll()
    {
        foreach ($this->getDB()->query('SELECT * FROM adverts') as $advertData) {
            $result[] = new Advert($advertData);
        }

        return $result;
    }

    public function getOne(int $id)
    {
        $db = $this->getDB();
        $stm = $db->prepare("SELECT * FROM adverts WHERE id = ? LIMIT 1");
        $stm->bindValue(1, $id, PDO::PARAM_INT);
        $stm->execute();
        $advertData = $stm->fetch(PDO::FETCH_ASSOC);

        $result[] = new Advert($advertData);

        return $result;
    }

    public function create(array $advertData): Advert
    {
        $db = $this->getDB();
        $stm = $db->prepare("INSERT INTO Adverts (title, description, price) VALUES (?, ?, ?)");
        $stm->bindValue(1, $advertData["title"], PDO::PARAM_STR);
        $stm->bindValue(2, $advertData["description"], PDO::PARAM_STR);
        $stm->bindValue(3, $advertData["price"], PDO::PARAM_INT);

        $stm->execute();

        return new Advert($advertData);
    }

    public function edit(array $advertData, int $id)
    {
        $db = $this->getDB();
        $stm = $db->prepare("UPDATE Adverts SET title = ?, description = ?, price = ? WHERE id = ?");
        $stm->bindValue(1, $advertData["title"], PDO::PARAM_STR);
        $stm->bindValue(2, $advertData["description"], PDO::PARAM_STR);
        $stm->bindValue(3, $advertData["price"], PDO::PARAM_INT);
        $stm->bindValue(4, $id, PDO::PARAM_INT);

        $stm->execute();
    }
}
