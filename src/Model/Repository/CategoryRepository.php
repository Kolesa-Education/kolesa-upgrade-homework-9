<?php

namespace App\Model\Repository;

use App\Model\Entity\Category;

class CategoryRepository
{
    private const DB_PATH = '../storage/categories.json';

    public function getAll()
    {
        $result = [];

        foreach ($this->getDB() as $categoryData) {
            $result[] = new Category($categoryData);
        }

        return $result;
    }

    public function getById(int $id){
        $arr = $this->getDB();
        foreach ($arr as $categoryData) {
            if($categoryData["id"] === $id){
                return new Category($categoryData);
            }
        }
        return null;
    }

    public function create(array $categoryData): Category {
        $db               = $this->getDB();
        $increment        = array_key_last($db) + 1;
        $categoryData['id'] = $increment;
        $db[$increment]   = $categoryData;

        $this->saveDB($db);

        return new Category($categoryData);
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
