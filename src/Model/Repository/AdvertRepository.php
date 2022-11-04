<?php

namespace App\Model\Repository;

use App\Model\Entity\Advert;
use App\Model\Entity\DB;
use PDO;
use PDOException;

class AdvertRepository
{
    private $table_name = 'adverts';

    // TODO: нужно нормально в db засунуть, а то ужас какой-то одно и тоже 500 раз писать

    public function getAll()
    {
        try {
            $sql = "SELECT * FROM `". $this->table_name ."`";

            $db = new DB();

            $results = $db->makeQueryForAll($sql);

            $db = null;

            $adverts = array();

            foreach($results as $result){
                $advert = new Advert($result);
                array_push($adverts, $advert);
            }

            return $adverts;
        } catch (PDOException $e){
            throw new PDOException($e->getMessage());
        }
    }

    public function getById(int $id)
    {
        try {
            $sql = "SELECT * FROM `". $this->table_name ."` WHERE id = " . $id;

            $db = new DB();

            $result = $db->makeQuery($sql);

            $db = null;
            
            $advert = new Advert($result);

            return $advert;
        } catch (PDOException $e){
            throw new PDOException($e->getMessage());
        }
    }

    public function create(array $advertData): Advert {
        try {
            $sql = "INSERT INTO `". $this->table_name ."`(title, description, price) VALUES (:title, :description, :price)";

            $db = new DB();

            $db->makeExecution($sql, $advertData);

            $db = null;
            
            $advert = new Advert($advertData);

            return $advert;
        } catch (PDOException $e){
            throw new PDOException($e->getMessage());
        }
    }

    public function update(array $advertData): Bool {
        try {
            $sql = "UPDATE `". $this->table_name ."` SET title=:title, description=:description, price=:price WHERE id=:id";

            $db = new DB();

            $result = $db->makeExecution($sql, $advertData);

            $db = null;

            if(!$result){
                return false;
            }
            
            return true;
        } catch (PDOException $e){
            throw new PDOException($e->getMessage());
        }
    }
}
