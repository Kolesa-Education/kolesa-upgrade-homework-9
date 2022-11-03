<?php
namespace App\Model\Repository;

use App\Model\Entity\Advert;
use App\Model\Entity\Category;
use \PDO;

class AdvertRepository
{
    private $dsn = 'mysql:dbname=adverts;host=127.0.0.1;port=3306';
    private $user = 'root';
    private $pass = 'pa55word';

    public function connect()
    {
        $conn = new PDO($this->dsn, $this->user, $this->pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    }
    public function create(array $advertData){
        $sql = "Insert into adverts (title,description,price) values (:title,:description,:price)";
        $title = $advertData["title"];
        $description = $advertData["description"];
        $price = $advertData["price"];
        $db = new AdvertRepository();
        $conn = $db->connect();

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $result = $stmt->execute();
        $db = null;

        return $result;
    }
    public function getAll(){
        $sql = "SELECT adverts.id,adverts.title,adverts.description,adverts.price, c.category_name FROM adverts join categories c on c.id = adverts.category_id";
        $db = new AdvertRepository();
        $conn = $db->connect();
        $stmt = $conn->query($sql);
        $dbResult = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        foreach ($dbResult as $advertData) {
            $result[] = new Advert((array)$advertData);
        }
        return $result;
    }
    public function getById($id){
        $sql = "Select * From adverts WHERE id = $id";
        $db = new AdvertRepository();
        $conn = $db->connect();
        $stmt = $conn->query($sql);
        $dbResult = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        return new Advert((array)$dbResult[0]);
    }
    public function update(array $advertData){
        $sql = "UPDATE adverts SET title = :title, description = :description, price = :price WHERE id = :id";
        $id = $advertData["id"];
        $title = $advertData["title"];
        $description = $advertData["description"];
        $price = $advertData["price"];
        $db = new AdvertRepository();
        $conn = $db->connect();

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':id', $id);
        $result = $stmt->execute();
        $db = null;

        return $result;
    }
    public function getCategories(){
        $sql = "Select * From categories";
        $db = new AdvertRepository();
        $conn = $db->connect();
        $stmt = $conn->query($sql);
        $dbResult = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        foreach ($dbResult as $advertData) {
            $result[] = new Category((array)$advertData);
        }
        return $result;
    }
}