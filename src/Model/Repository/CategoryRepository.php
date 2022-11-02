<?php

namespace App\Model\Repository;

use App\Model\Entity\Category;
use PDO;
use PDOException;

use function PHPSTORM_META\type;

class CategoryRepository
{
    private const CONFIG_PATH = '../src/Model/Repository/db_config.json';
    private PDO $connection;

    public function __construct()
    {
        $config = json_decode(file_get_contents(self::CONFIG_PATH), true) ?? [];
        
        $dns = 'mysql:host='.$config["host"].';dbname='.$config["dbName"];
        try{
            $dbConnection = new PDO($dns, $config["username"], $config["password"]);
        }catch(PDOException $e){
            return null;
        }
        
        
        $this->setConnection($dbConnection);
    }

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

    private function getDB(): array
    {
        $categories = $this->getConnection()->query("SELECT * FROM categories");
        return $categories->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get the value of connection
     *
     * @return PDO
     */
    public function getConnection(): PDO
    {
        return $this->connection;
    }

    /**
     * Set the value of connection
     *
     * @param PDO $connection
     *
     * @return self
     */
    public function setConnection(PDO $connection): self
    {
        $this->connection = $connection;

        return $this;
    }
}
