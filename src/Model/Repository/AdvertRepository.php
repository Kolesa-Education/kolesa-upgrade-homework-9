<?php

namespace App\Model\Repository;

use App\Model\Entity\Advert;
use PDO;

class AdvertRepository extends Dbh
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
/*
    public function create(array $advertData): Advert 
    {
        $db               = $this->getDB();
        $increment        = array_key_last($db) + 1;
        $advertData['id'] = $increment;
        $db[$increment]   = $advertData;

        $this->saveDB($db);

        return new Advert($advertData);
    }

    public function read(int $id): Advert
    {
        $db = $this->getDB();
        $advertData = $db[$id];
        
        return new Advert($advertData);
    }

    public function update(array $advertData): Advert 
    {
        $db            = $this->getDB();
        $advertId      = $advertData[$id];
        $advertData    = $db[$advertId];
        
        $this->saveDB($db);

        return new Advert($advertData);
    }

    private function getDB(): array
    {
        return json_decode(file_get_contents(self::DB_PATH), true) ?? [];
    }

    private function saveDB(array $data): void
    {
        file_put_contents(self::DB_PATH, json_encode($data, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT));
    }
*/
    protected function read(int $id)
    {
        $stmt = $this->connect()->prepare('SELECT id FROM adverts WHERE id = ?;');

        if ($stmt->execute(array($id)))
        {
            $stmt = null;
            header("location: ../public/index/php?error=stmtfailed");
            exit();
        }

        $resultCheck;
        if ($stmt->rowCount() > 0)
        {
            $resultCheck = false;
        } else {
            $resultCheck = true;
        }
        
        return $resultCheck;
    }

    protected function create(array $advertData)
    {
        $stmt = $this->connect()->prepare('INSERT INTO adverts (title, [description], price) VALUES (?, ?, ?);');

        $stmt = execute();

        return new Advert($advertData);

    }

    protected function update(array $advertData)
    {
        $stmt = $this->connect()->prepare('UPDATE adverts SET title = ?, [description] = ?, price = ? WHERE id = :id;');

        $stmt = execute();

        return new Advert($advertData);
    }
}
