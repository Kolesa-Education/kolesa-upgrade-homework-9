<?php

namespace App\Model\Repository;

use App\Model\Entity\Advert;
use PDO;

class AdvertRepository
{
    private const DB_PATH = './storage/adverts.json';
    private static $pdo;
    private $link;

    public function __construct()
    {
        $this->connect();
    }

    private function connect()
    {
        $config = require_once 'config.php';
        $dsn = 'mysql:host=' . $config['host'] . ';dbname=' . $config['db_name'] . ';charset=' . $config['charset'];
        $this->link = new PDO($dsn, $config['username'], $config['password']);
        return $this;
    }

    public function execute($sql)
    {
        $sth = $this->link->prepare($sql);
        return $sth->excute();
    }

    public function query($sql)
    {
        $sth = $this->link->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        if ($result === false) {
            return [];
        }
        return $result;
    }

    public function getAll(): array
    {
        $result = [];
        $stmt = self::$pdo->query('SELECT * FROM adverts');
        $data = $stmt->fetchAll();

        foreach ($data as $advertData) {
            $result[] = new Advert($advertData);
        }
        return $result;
    }

    public function create(array $advertData): Advert
    {
        $db = $this->getDB();
        $title = $advertData['title'];
        $description = $advertData['description'];
        $price = $advertData['price'];
        $sql = "INSERT INTO adverts(title, description, price)values (?, ?, ?)";
        $stmt = $db->prepare($sql)->execute([$title, $description, $price]);
        return new Advert($advertData);
    }

    private function getDB()
    {
        return self::$pdo;
    }

    public function edit(array $advertData, int $id)
    {
        $db = $this->getDB();
        $title = $advertData['title'];
        $description = $advertData['description'];
        $price = $advertData['price'];
        $sql = "UPDATE adverts SET title=?, description=?, price=? WHERE id=?";
        $db->prepare($sql)->execute([$title, $description, $price, $id]);
        return new Advert($advertData);
    }
    public function deleteAdvert(array $advertData, int $id): Advert
    {
        $db = $this->getDB();
        $title = $advertData['title'];
        $description = $advertData['description'];
        $price = $advertData['price'];
        $sql = "DELETE adverts WHERE id=?";
        $db->prepare($sql)->execute( [$id]);
        return new Advert($advertData);
    }
}