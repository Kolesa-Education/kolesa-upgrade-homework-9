<?php

namespace App\Model\Repository;

use App\Model\Entity\Advert;
use PDO;

class AdvertRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new Advert();
        $this->table = 'adverts';
    }

    public function getByCategoryAndTitle(int $categoryId, string $title)
    {
        $result = [];
        $title = "%$title%";

        if ($categoryId != 0) {
            $sql = "SELECT * FROM {$this->table} WHERE category_id = :category AND title LIKE :title";

            $stmt = $this->connection->prepare($sql);

            $stmt->bindValue("category", $categoryId);
            $stmt->bindValue("title", $title);
        } else {
            $sql = "SELECT * FROM {$this->table} WHERE title LIKE :title";

            $stmt = $this->connection->prepare($sql);

            $stmt->bindValue("title", $title);
        }

        $stmt->execute();

        $records = $stmt->fetchAll(PDO::FETCH_OBJ);

        foreach ($records as $record) {
            $result[] = new $this->model(json_decode(json_encode($record),true));
        }

        return $result;
    }

    public function create(array $advertData): Advert {
        $sql = "INSERT INTO adverts (title, 
                                    description, 
                                    price, 
                                    category_id
                                    ) 
                VALUES (:title, 
                        :description, 
                        :price, 
                        :category_id
                        )";

        $this->prepareSql($sql, $advertData);

        return new Advert($advertData);
    }

    public function update(array $advertData): Advert
    {
        $sql = "UPDATE adverts 
                SET title = :title, 
                    description = :description, 
                    price = :price, 
                    category_id = :category_id
                WHERE id = :id";

        $this->prepareSql($sql, $advertData);

        return new Advert($advertData);
    }

    private function prepareSql(string $sql, array $data): void
    {
        $stmt = $this->connection->prepare($sql);

        $stmt->bindValue("title", $data['title']);
        $stmt->bindValue("description", $data['description']);
        $stmt->bindValue("price", $data['price']);
        $stmt->bindValue("category_id", $data['category_id']);

        $stmt->execute();
    }
}
