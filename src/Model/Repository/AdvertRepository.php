<?php

namespace App\Model\Repository;
use App\Model\Entity\Advert;
use PDO;
use App\Model\Repository\dbconnection;
use App\index;


class AdvertRepository
{
    public function getAll()
    {
        $result = [];
        $data = conect()->query('SELECT * FROM adverts');
        foreach($data as $rows) {
            $result[] = $rows;
        }
        return $result;
    }

    public function getId(int $id){
        $result = [];
        $data = conect()->query("SELECT * FROM adverts WHERE id = {$id}");
        foreach ($data as $advert) {
            if ($advert['id'] == $id) {
                $result[] = $advert;
            }
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
}
