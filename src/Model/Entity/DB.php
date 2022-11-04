<?php

namespace App\Model\Entity;
use PDO;

class DB{
    private const DOMAIN = 'localhost';
    private const DATABASENAME = 'db';
    private const LOGIN = 'root';
    private const PASSWORD = 'root';

    private function connect()
    {
        $conn_str = "mysql:host=" . self::DOMAIN .";dbname=" . self::DATABASENAME;
        $conn = new PDO($conn_str, self::LOGIN, self::PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    }

    public function run(string $request) : array {
        $conn = $this->connect();
        $stmt = $conn->query($request);
        return $stmt->fetchAll();
    }

    public function runone(string $request) : array {
        $conn = $this->connect();
        $stmt = $conn->query($request);
        return $stmt->fetch();
    }

    public function dosql(string $request, array $data){
        $conn = $this->connect();
        $stmt = $conn->prepare($request);
        return $stmt->execute($data);
    }
}