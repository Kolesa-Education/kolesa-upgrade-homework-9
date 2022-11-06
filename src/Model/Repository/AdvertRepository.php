<?php

namespace App\Model\Repository;

use App\Model\Entity\Advert;
use App\Model\Repository\DBConnect\Connector;

class AdvertRepository
{
    private const DB_PATH = '../storage/adverts.json';

    public function __construct()
    {
        $host = 'localhost';
        $db = 'AdvertsDB';
        $user = 'root';
        $pass = 'Applejesus$#1';
        $charset = 'utf8';
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $opt = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        $pdo = new PDO($dsn, $user, $pass, $opt);
        return $pdo;
    }

    public function getAll()
    {
        $result = [];

        foreach ($this->getDB() as $advertData) {

            $result[] = new Advert($advertData);
        }
        return $result;
    }

    public function create(array $advertData): Advert
    {
        $db = $this->getDB();
        $increment = array_key_last($db) + 1;
        $advertData['id'] = $increment;
        $db[$increment] = $advertData;

        $this->saveDB($db, $increment);

        return new Advert($advertData);
    }

    public function edit(array $advertData, $id): Advert
    {
        $db = $this->getDB();
        $advertData['id'] = $id;
        $db[$id] = $advertData;
        $this->UpdateDB($db, $id);

        return new Advert($advertData);
    }

    private function getDB(): array
    {
        $stmt = $this->query('SELECT * FROM Adverts');
        $result = $stmt->fetchall();
        return $result;
    }

    public function getById(int $id): Advert
    {
        $adArray = $this->getDB();
        for ($i = 0; $i <= count($adArray); $i++) {
            if ($adArray[$i]['id'] == $id) {
                $advertData = $adArray[$i];
                return new Advert($advertData);
            }
        }

    }

    private function saveDB(array $data, $increment): void
    {
        $stmt = $this->prepare('insert into Adverts values (?,?,?,?)');
        $stmt->execute(array($data[$increment]['title'], $data[$increment]['description'], $data[$increment]['price'], $data[$increment]['id']));
    }

    private function UpdateDB(array $data, $id): void
    {
        $stmt = $this->prepare('UPDATE Adverts
        SET title =?, description = ?, price = ?
        WHERE id = ?');
        $stmt->execute(array($data[$id]['title'], $data[$id]['description'], $data[$id]['price'], $id));
    }


}
