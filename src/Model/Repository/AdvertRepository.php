<?php

namespace App\Model\Repository;

use App\Model\Entity\Advert;
use App\Model\Entity\Category;
use PDO;
use PDOException;

use App\Model\Repository\CategoryRepository;

class AdvertRepository extends AbstractRepository
{


    public function getAll()
    {
        $result = [];

        foreach ($this->getDB() as $advertData) {
            $advertObject = new Advert($advertData);

            $categoryRepo = new CategoryRepository();
            $categoryId = $advertData["category_id"];
            $categoryObject = $categoryRepo->getById($categoryId);
            
            $advertObject->setCategory($categoryObject);
            $result[] = $advertObject;
        }

        return $result;
    }

    public function getById(int $id){
        $advertOutput = $this->getConnection()->query("SELECT * FROM adverts WHERE id=$id;")->fetchAll(PDO::FETCH_ASSOC);
        
        if(count($advertOutput) === 0){
            return null;
        }
        $advertOutput = $advertOutput[0];

        $categoryRepo = new CategoryRepository();
        $categoryId = $advertOutput["category_id"];
        $categoryObject = $categoryRepo->getById($categoryId);

        $advertObject = new Advert($advertOutput);
        $advertObject->setCategory($categoryObject);
        
        
        return $advertObject;
    }

    public function getByCategoryId(int $id){
        $advertOutput = $this->getConnection()->query("SELECT * FROM adverts WHERE category_id=$id;")->fetchAll(PDO::FETCH_ASSOC);
        
        if(count($advertOutput) === 0){
            return null;
        }
        $result = [];

        foreach ($advertOutput as $advertData) {
            $advertObject = new Advert($advertData);

            $categoryRepo = new CategoryRepository();
            $categoryId = $advertData["category_id"];
            $categoryObject = $categoryRepo->getById($categoryId);
            
            $advertObject->setCategory($categoryObject);
            $result[] = $advertObject;
        }

        return $result;
    }

    public function getByTitle(string $text){
        $advertOutput = $this->getConnection()->query("SELECT * FROM adverts WHERE CONTAINS(title, $text);")->fetchAll(PDO::FETCH_ASSOC);
        
        if(count($advertOutput) === 0){
            return null;
        }
        $result = [];

        foreach ($advertOutput as $advertData) {
            $advertObject = new Advert($advertData);

            $categoryRepo = new CategoryRepository();
            $categoryId = $advertData["category_id"];
            $categoryObject = $categoryRepo->getById($categoryId);
            
            $advertObject->setCategory($categoryObject);
            $result[] = $advertObject;
        }

        return $result;
    }

    public function create(array $advertData): Advert {
        $query = "INSERT INTO adverts(title, description, price, category_id) VALUES (:title, :description, :price, :category_id)";

        $result_query = $this->connection->prepare($query);
        $result_query->execute($advertData);

        return new Advert($advertData);
    }

    public function update(int $id, array $advertData) {
        $query = "
                    UPDATE adverts 
                    SET title=:title, description=:description, price=:price, category_id=:category_id  
                    WHERE id=$id
                ";
        $result_query = $this->connection->prepare($query);
        $result_query->execute($advertData);

        return new Advert($advertData);
    }

    protected function getDB(): array
    {
        $adverts = $this->getConnection()->query("SELECT * FROM adverts");
        return $adverts->fetchAll(PDO::FETCH_ASSOC);
    }
}
