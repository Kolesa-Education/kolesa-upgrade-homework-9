<?php

namespace App\Model\Repository;

use App\Model\Entity\Advert;

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

    public function getById(int $id): ?Advert{
        $adverts = $this->getDB();
        for ($i=0; $i<count($adverts); $i++){
            if ($adverts[$i]['id'] == $id){
                return new Advert($adverts[$i]);
            }
        }
        return null;
    }

    public function edit(array $advertData): Advert {
        $db = $this->getDB();
        $db[$advertData['id']] = $advertData;

        $this->saveDB($db);

        return new Advert($advertData);
    }

    public function create(array $advertData): Advert {
        $db               = $this->getDB();
        $increment        = array_key_last($db) + 1;
        $advertData['id'] = $increment;
        $db[$increment]   = $advertData;

        $this->saveDB($db);

        return new Advert($advertData);
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
