<?php

namespace App\Model\Repository;

use App\Model\Entity\Advert;

class AdvertRepository extends Repository
{
    public function getAll()
    {
        $records = $this->conn->query("SELECT * FROM adverts")->fetchAll();
        foreach ($records as $record) {
            $res[] = new Advert($record);
        }

        return $res;
    }

    public function create(array $data)
    {
        $title = $data['title'];
        $description = $data['description'];
        $price = $data['price'];
        $categoryId = $data['categoryId'];

        try {
            $this->conn->exec(
                "INSERT INTO adverts (title, description, price, category_id) VALUES ('{$title}', '{$description}', {$price}, {$categoryId})");
            return true;
        } catch (\PDOException $e) {
            return $e;
        }
    }

    public function getAdvertById(int $id)
    {
        try {
            return new Advert($this->conn->query("SELECT * FROM adverts WHERE id = {$id}")->fetch());
        } catch (\PDOException) {
            return false;
        }
    }

    public function updateAdvertById(int $id, array $data)
    {
        $title = $data['title'];
        $description = $data['description'];
        try {
            $this->conn->query("UPDATE adverts SET title = '{$title}', description = '{$description}' WHERE id = {$id}");
            return true;
        } catch (\PDOException) {
            return false;
        }
    }

}
