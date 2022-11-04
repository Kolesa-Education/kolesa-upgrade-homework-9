<?php

namespace App\Model\Entity;
use PDO;

class DB{
    private const HOST = 'localhost';
    private const DB_NAME = 'homework';
    private const USERNAME = 'root';
    private const PASSWORD = 'root';
    private const TABLE_NAME = 'adverts';

    private function connect()
    {
        $conn_str = "mysql:host=" . self::HOST .";dbname=" . self::DB_NAME;
        $conn = new PDO($conn_str, self::USERNAME, self::PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;
    }

    public function makeQueryForAll(string $sql) : array {
        $conn = $this->connect();

        $stmt = $conn->query($sql);

        $results = $stmt->fetchAll();

        return $results;
    }

    public function makeQuery(string $sql) : array {
        $conn = $this->connect();

        $stmt = $conn->query($sql);

        $result = $stmt->fetch();

        if(!$result){
            return array();
        }

        return $result;
    }

    public function makeExecution(string $sql, array $data){
        $conn = $this->connect();

        $stmt = $conn->prepare($sql);

        return $stmt->execute($data);
    }
}