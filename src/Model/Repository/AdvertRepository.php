<?php

namespace App\Model\Repository;

use App\Model\Entity\Advert;
use App\Model\Repository\DBConnect\Connector;

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

        $this->saveDB($db, $increment);

        return new Advert($advertData);
    }
    public function edit(array $advertData,$id): Advert {
        $db = $this->getDB();
        $advertData['id'] = $id;
        $db[$id]   = $advertData;
        $this->UpdateDB($db,$id);

        return new Advert($advertData);
    }

    private function getDB(): array
    {
        //ЗДЕСЬ РЕАЛИЗАЦИЯ БД
        $con = new Connector();
        $result = $con->GetData();
        // $result = json_decode(file_get_contents(self::DB_PATH), true) ?? [];

        return $result;
    }

    public function getById(int $id): Advert
    {
        $adArray = $this->getDB();
        for($i = 0; $i<=count($adArray); $i++){
            if($adArray[$i]['id'] == $id){
                $advertData = $adArray[$i];
                return new Advert($advertData);
            }
        }
        
    }

    private function saveDB(array $data,$increment):void
    {
        $con = new Connector();
        $result = $con->CreateData($data[$increment]['title'],$data[$increment]['description'],$data[$increment]['price'],$data[$increment]['id']);
    }

    private function UpdateDB(array $data,$id):void
    {
        $con = new Connector();
        $result = $con->EditData($data[$id]['title'],$data[$id]['description'],$data[$id]['price'],$id);
    }

    
}
