<?php

namespace App\Model\Repository;

use App\Model\Entity\Category;
use mysql_xdevapi\TableUpdate;

class CategoryRepository extends Repository
{
    public function getAll()
    {
        $records = $this->conn->query("SELECT * FROM categories")->fetchAll();
        foreach ($records as $record) {
            $res[] = new Category($record);
        }

        return $res;
    }

    public function create(array $data)
    {
        $title = $data['title'];
        $description = $data['description'];

        try {
            $this->conn->exec("INSERT INTO categories (title, description) VALUES ('{$title}', '{$description}')");
            return true;
        } catch (\PDOException $e) {
            return $e;
        }
    }

    public function getCategoryById(int $id)
    {
        try {
            return new Category($this->conn->query("SELECT * FROM categories WHERE id = {$id}")->fetch());
        } catch (\PDOException $e) {
            return $e;
        }
    }

    public function getAdvertsByCategoryId(int $id)
    {
        $records = $this->conn->query("SELECT * FROM adverts WHERE category_id = {$id}")->fetchAll();
        foreach ($records as $record) {
            $res[] = new Category($record);
        }

        return $res;
    }

    public function updateCategoryById(int $id, array $data)
    {
        $title = $data['title'];
        $description = $data['description'];
        try {
            $this->conn->query("UPDATE categories SET title = '{$title}', description = '{$description}' WHERE id = {$id}");
            return true;
        } catch (\PDOException) {
            return false;
        }
    }
}
