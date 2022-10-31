<?php

namespace App\Model\Repository;

use App\Model\Entity\Advert;

class AdvertRepository
{
    // private const DB_PATH = '../storage/adverts.json';
    private const DB_HOST = 'localhost';
    private const DB_USER = 'root';
    private const DB_PASS = '';
    private const DB_NAME = 'adverts';

    public function getAll()
    {
        $result = [];

        foreach ($this->getDB() as $advertData) {
            $result[] = new Advert($advertData);
        }

        return $result;
    }

    public function getById(int $id): Advert
    {
        $adArray = $this->getDB();
        $advertData = $adArray[$id];
        
        return new Advert($advertData);
    }

    public function create(array $advertData): Advert {
        $this->saveDB($advertData);

        return new Advert($advertData);
    }

    public function edit(array $advertData): Advert {
        $this->saveDB($advertData);

        return new Advert($advertData);
    }

    private function getDB(): array
    {
        $link = mysqli_connect(self::DB_HOST, self::DB_USER, self::DB_PASS, self::DB_NAME);
        if ($link == false){
            print("Ошибка: Невозможно подключиться к MySQL " . mysqli_connect_error());
            return [];
        }
        else {
            print("Соединение установлено успешно");
        }
        mysqli_set_charset($link, "utf8");

        $sql = 'SELECT id, title, description, price FROM adverts';
        $result = mysqli_query($link, $sql);
        $ads = mysqli_fetch_all($result, MYSQLI_ASSOC);

        return $ads ?? [];
    }

    private function saveDB(array $data):void
    {
        $link = mysqli_connect(self::DB_HOST, self::DB_USER, self::DB_PASS, self::DB_NAME);
        if ($link == false){
            print("Ошибка: Невозможно подключиться к MySQL " . mysqli_connect_error());
            return;
        }
        else {
            print("Соединение установлено успешно");
        }
        mysqli_set_charset($link, "utf8");

        $adTitle = $data['title'];
        $adDescription = $data['description'];
        $adPrice = $data['price'];
        $sql = 'INSERT INTO adverts(title, description, price) 
                VALUES ' . $adTitle . ', ' . $adDescription .', ' . $adPrice;
        
        $result = mysqli_query($link, $sql);
        if ($result == false) {
            print("Произошла ошибка при выполнении запроса");
        }
    }
}
