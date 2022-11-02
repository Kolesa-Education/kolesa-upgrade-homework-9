<?php

namespace App\Model\Repository;

use App\Model\Entity\Advert;

class AdvertRepository
{
    // private const DB_PATH = '../storage/adverts.json'; 
    private const dbHost = 'localhost';
    private const dbUser = 'root';
    private const dbPass = '';
    private const dbName = 'adverts_homework9';

    public function getAll()
    {
        $result = [];

        foreach ($this->getDB() as $advertData) {
            $result[] = new Advert($advertData);
        }

        return $result;
    }

    public function getByTitle($title)
    {
        $result = [];

        foreach ($this->getWithTitle($title) as $advertData) {
            $result[] = new Advert($advertData);
        }

        return $result;
    }

    public function getAdvert($id)
    {
        $db = $this->getDB();
        $result = [];
        $result[] = new Advert($db[$id-1]);

        return $result[0];
    }

    public function create(array $advertData): Advert
    {
        $this->saveDB($advertData);

        return new Advert($advertData);
    }

    public function edit(array $advertData): Advert
    {
        $this->updateDB($advertData);
        return new Advert($advertData);
    }

    private function getWithTitle($title): array
    {
        // return json_decode(file_get_contents(self::DB_PATH), true) ?? [];
        $conn = mysqli_connect(self::dbHost, self::dbUser, self::dbPass, self::dbName);
        if ($conn == false) {
            print(mysqli_connect_error());
            return [];
        }
        mysqli_set_charset($conn, "utf8");

        $sql = 'SELECT `id`, `title`, `description`, `price` FROM `adverts` WHERE `title` LIKE "%'.$title.'%"';
        $result = mysqli_query($conn, $sql);
        $allAdverts = mysqli_fetch_all($result, MYSQLI_ASSOC);

        return $allAdverts ?? [];
    }

    private function getDB(): array
    {
        // return json_decode(file_get_contents(self::DB_PATH), true) ?? [];
        $conn = mysqli_connect(self::dbHost, self::dbUser, self::dbPass, self::dbName);
        if ($conn == false) {
            print(mysqli_connect_error());
            return [];
        }
        mysqli_set_charset($conn, "utf8");

        $sql = 'SELECT `id`, `title`, `description`, `price` FROM `adverts`';
        $result = mysqli_query($conn, $sql);
        $allAdverts = mysqli_fetch_all($result, MYSQLI_ASSOC);

        return $allAdverts ?? [];
    }

    private function saveDB(array $data): void
    {
        // file_put_contents(self::DB_PATH, json_encode($data, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT));
        $conn = mysqli_connect(self::dbHost, self::dbUser, self::dbPass, self::dbName);
        if ($conn == false) {
            print(mysqli_connect_error());
            return;
        } else {
            print("success");
        }
        mysqli_set_charset($conn, "utf8");

        $title = $data['title'];
        $description = $data['description'];
        $price = $data['price'];
        print_r($data['description'], $data['price']);
        $sql = 'INSERT INTO adverts(title, description, price) VALUES ("' . $title . '", "' . $description . '", ' . $price.')';

        $result = mysqli_query($conn, $sql);
        if ($result == false) {
            print("Произошла ошибка при выполнении запроса");
        }
    }

    private function updateDB(array $data): void
    {
        // file_put_contents(self::DB_PATH, json_encode($data, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT));
        $conn = mysqli_connect(self::dbHost, self::dbUser, self::dbPass, self::dbName);
        if ($conn == false) {
            print(mysqli_connect_error());
            return;
        } else {
            print("success");
        }
        mysqli_set_charset($conn, "utf8");

        $id = $data['id'];
        $title = $data['title'];
        $description = $data['description'];
        $price = $data['price'];
        print_r($data['description'], $data['price']);
        $sql = 'UPDATE adverts SET title = "' . $title . '", description = "' . $description . '", price = ' . $price.' WHERE id = '. $id .';';

        $result = mysqli_query($conn, $sql);
        if ($result == false) {
            print("Произошла ошибка при выполнении запроса");
        }
    }
}
