<?php

namespace App\Model\Repository;

use App\Model\Entity\Advert;
use mysqli;

class AdvertRepository
{
    private const DB_PATH = '../storage/adverts.json';
    private const DB_CFG = '../src/Model/Repository/db_config.json';

    public function getAll()
    {
        $result = [];

        foreach ($this->getDB() as $advertData) {
            $result[] = new Advert($advertData);
        }

        return $result;
    }

    public function create(array $advertData): Advert {

        $this->saveDB($advertData, 'insert');

        return new Advert($advertData);
    }

    public function update(array $advertData): Advert {

        $this->saveDB($advertData, 'update');

        return new Advert($advertData);
    }

    private function getDB(): array
    {
        $db = $this->db_connect();
        $query = 'select * from Adverts order by id';
        $result = $db -> query($query);
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data ?? [];
    }

    private function saveDB(array $data, string $type):void
    {
        $db = $this->db_connect();

        switch ($type){
            case 'insert':
                $stmt = $db->prepare("insert into Adverts (title, description, price) values (?, ?, ?)");
                $stmt->bind_param('ssi', $data['title'], $data['description'], $data['price']);
            case 'update':
                $stmt = $db->prepare("update Adverts set title=?, description=?, price=? where id=?");
                $stmt->bind_param( 'ssii', $data['title'], $data['description'], $data['price'], $data['id']);
        }

        $stmt->execute();
    }

    private function db_connect(): mysqli
    {
        $db_cfg = json_decode(file_get_contents(self::DB_CFG), true);
        $host = $db_cfg['DB']['host'];
        $user = $db_cfg['DB']['user'];
        $pass = $db_cfg['DB']['pass'];
        $db_name = $db_cfg['DB']['db_name'];
        $mysql = new mysqli($host, $user, $pass, $db_name);

        return $mysql;
    }
}
