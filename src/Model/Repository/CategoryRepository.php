<?php

namespace App\Model\Repository;

use App\Model\Entity\Category;
use PDO;
use PDOException;


class CategoryRepository extends AbstractRepository
{

    public function getAll()
    {
        $result = [];

        foreach ($this->getDB() as $categoryData) {
            $result[] = new Category($categoryData);
        }

        return $result;
    }

    public function getById(int $id)
    {
        $categoryOutput = $this->getConnection()->query("SELECT * FROM categories WHERE id=$id")->fetchAll(PDO::FETCH_ASSOC);
        if(count($categoryOutput) === 0){
            return null;
        }
        $categoryOutput = $categoryOutput[0];
        $categoryObject = new Category($categoryOutput);
        return $categoryObject;
    }

    protected function getDB(): array
    {
        $categories = $this->getConnection()->query("SELECT * FROM categories");
        return $categories->fetchAll(PDO::FETCH_ASSOC);
    }
}
