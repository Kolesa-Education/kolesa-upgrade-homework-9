<?php

namespace App\Model\Entity;

use PDO;

class DatabaseConnection {
    private static $instance = null;
    private $conn;
    
    private $host = '127.0.0.1';
    private $db   = 'adverts';
    private $user = 'root';
    private $port = "3307";
    private $pass = 'Miracle.1208';
    private $charset = 'utf8mb4';
    
    private $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    
    private function __construct()
    {
        $this->conn = new \PDO("mysql:host={$this->host}; dbname={$this->db}; charset={$this->charset}; port={$this->port}", $this->user, $this->pass, $this->options);
    }
    
    public static function getInstance()
    {
        if(!self::$instance)
        {
        self::$instance = new DatabaseConnection();
        }
    
        return self::$instance;
    }
    
    public function getConnection()
    {
        return $this->conn;
    }
}