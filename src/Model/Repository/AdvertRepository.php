<?php

namespace App\Model\Repository;

use App\Model\Entity\Advert;
use App\Model\Entity\Exception;

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

    public function create(array $advertData): Advert {
        $db               = $this->getDB();
        $increment        = array_key_last($db) + 1;
        $advertData['id'] = $increment;
        $db[$increment]   = $advertData;

        $this->saveDB($db);

        return new Advert($advertData);
    }

    public function put(array $advertData): Advert {
        $db    = $this->getDB();;
        $db[$advertData->getID()]   = $advertData;
        $this->saveDB($db);
        return new Advert($advertData);
    }    

    public function getAdvertById(int $id): Advert {
        foreach ($this->getAll() as $advertData) {
            if($advertData->getID() === $id) {
                $advert = $advertData;
                return $advert;
            }
        }
        throw new Exception('not found');
    }

    public function editAdvertById(int $id): Advert {
        foreach ($this->getAll() as $advertData) {
            if($advertData->getID() === $id) {
                $advert = new Advert($advertData);
                return $advert;
            }
        }
        throw new Exception('not found');
    }


    private function getDB(): array
    {
        return json_decode(file_get_contents(self::DB_PATH), true) ?? [];
    }

    private function saveDB(array $data):void
    {
        file_put_contents(self::DB_PATH, json_encode($data, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT));
    }
}
