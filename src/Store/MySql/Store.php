<?php

namespace App\Store\MySql;

use App\Model\DB\Db;
use App\Model\Entity\Advert;
use App\Model\Repository\AdvertRepository;
use \PDO;


class Store implements AdvertRepository{
    private Db $db;


    public function __construct(Db $db){
        $this->db= $db;
    }

    public function getAll(): array {
        $result = [];

        foreach ($this->getDB() as $advertData) {
            $result[] = new Advert((array)$advertData);
        }

        return $result;
    }

    public function getByID(int $id): array{
        $adverts = $this->getAll();
        
        $result = [];

        foreach ($adverts as $advert){
            if ($advert->getID() == $id){
                $result[] = $advert;
            } 
        }

        return $result;
    }

    public function createAdvert(Advert $advert){
        $conn = $this->db->connect();
        $stmt = $conn->prepare("INSERT INTO adverts (title, description, price, category_id) 
        VALUES (:title, :descr, :price, (SELECT id FROM category WHERE ctry_name=:category))");
        
        $title = $advert->getTitle();
        $desciption = $advert->getDescription();
        $price = $advert->getPrice();
        $category = $advert->getCategory();

        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':descr', $desciption);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category', $category);
        $stmt->execute();
        $conn = null;
    }

    private function getDB(): array {
        $sql = "SELECT adverts.*,  category.ctry_name FROM adverts LEFT JOIN category ON adverts.category_id=category.id;";
        
        $conn = $this->db->connect();
        $stmt = $conn->query($sql);
        $adverts = $stmt->fetchAll(PDO::FETCH_OBJ);
        $conn = null;

        return $adverts;
    }

    public function updateAdvert(int $id, Advert $advert){
        $conn = $this->db->connect();
        $stmt = $conn->prepare("UPDATE adverts SET title=(:title), description=(:descr), price=(:price),
        category_id=(SELECT category.id FROM category WHERE category.ctry_name=(:category)) WHERE id = (:id)");
       
        $title = $advert->getTitle();
        $desciption = $advert->getDescription();
        $price = $advert->getPrice();
        $category = $advert->getCategory();

        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':descr', $desciption);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':category', $category);
        $stmt->execute();
        $conn = null;
    }


    public function getCategories(): array{
        $sql = "SELECT ctry_name FROM category";

        $conn = $this->db->connect();
        $stmt = $conn->query($sql);
        $categories = $stmt->fetchAll(PDO::FETCH_OBJ);
        $conn = null;

        $result = [];

        foreach ($categories as $category){
            $result[] = (array)$category;        
        }

        return $result;
    }
}