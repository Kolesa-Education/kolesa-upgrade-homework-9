<?php

namespace App\Model\Repository;

use App\Model\Entity\Advert;
use mysql_xdevapi\Exception;
use mysqli;

class AdvertRepository
{
    private string $servername = "localhost";
    private string $dbname = "Adverts";
    private string $username = "root";
    private string $password = "";
    private mysqli $database;

    /**
     * @throws Exception if operation fail
     */
    public function __construct (){
            $this->database = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
    }

    public function getAll(): array
    {
        $adverts = [];
        $db = $this->database;
        $result = $db->query("SELECT * FROM Adverts");
        while($row = $result->fetch_assoc()) {
            $adverts[] = new Advert($row);
        }
        return $adverts;
    }

    public function getById(int $id): Advert {
        $db = $this->database;
        $result = $db->query("SELECT * FROM Adverts WHERE id = " . $id);
        $result = $result->fetch_assoc();
        $adv = new Advert($result);
        return $adv;
    }

    public function create(array $advertData): Advert {
        $db = $this->database;
        $stmt = $db->prepare("INSERT INTO Adverts (title, description, price) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $advertData["title"], $advertData["description"], $advertData["price"]);
        $stmt->execute();
        return new Advert($advertData);
    }

    public function update(array $advertData, int $id) {
        $db = $this->database;
        $stmt = $db->prepare("UPDATE Adverts SET title=?, description=?, price=? WHERE id=?");
        $stmt->bind_param("ssii",
            $advertData["title"],
            $advertData["description"],
            $advertData["price"],
            $id);
        $stmt->execute();
    }

}
