<?php

namespace App\Model\Repository;

use PDO;
use PDOException;

abstract class AbstractRepository
{
    private const CONFIG_PATH = '../src/Model/Repository/db_config.json';
    protected PDO $connection;


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


    abstract public function getAll();

    abstract public function getById(int $id);

    abstract protected function getDB();

    public function getConnection(): PDO
    {
        return $this->connection;
    }
    public function setConnection(PDO $connection): self
    {
        $this->connection = $connection;

        return $this;
    }
}
