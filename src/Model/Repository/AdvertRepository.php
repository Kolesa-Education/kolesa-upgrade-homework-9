<?php
namespace App\Model\Repository;
use App\Model\Entity\Advert;
use App\Model\Entity\DB;
use PDO;
use PDOException;

class AdvertRepository
{
    private $dbname = 'adverts';
    public function getAll()
    {
        $query = "SELECT * FROM `". $this->dbname ."`";
        $db = new DB();
        $results = $db->run($query);
        $result = array();
        foreach($val as $result){
            $val = new Advert($result);
            array_push($result, $val);
        }
        return $result;
    }

    public function getById(int $id)
    {
        $query = "SELECT * FROM `". $this->dbname ."` WHERE id = " . $id;
        $db = new DB();
        $result = $db->runone($query);
        return new Advert($result);
    }

    public function create(array $info): Advert {
        $query = "INSERT INTO `". $this->dbname ."`(title, description, price) VALUES (:title, :description, :price)";
        $db = new DB();
        $db->dosql($query, $info);
        return new Advert($info);
    }

    public function update(array $info) {
        $query = "UPDATE `". $this->dbname ."` SET title=:title, description=:description, price=:price WHERE id=:id";
        $db = new DB();
        $result = $db->dosql($query, $info);
    }
}
