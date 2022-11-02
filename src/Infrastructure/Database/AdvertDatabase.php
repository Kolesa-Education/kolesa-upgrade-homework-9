<?php

namespace App\Infrastructure\Database;

use App\Model\Entity\Advert;

class AdvertDatabase
{
    private const DB_HOST = 'localhost:3306';
    private const DB_USER = 'root';
    private const DB_PASS = 'root';
    private const DB_NAME = 'adverts';

    public static $connection;
    private static $instances = [];

    protected function __construct() {
        try {
            self::$connection = new \PDO("mysql:host=".
            self::DB_HOST . ";dbname=" . self::DB_NAME, self::DB_USER, self::DB_PASS);
            echo "Connected to " . self::DB_NAME . " at " . self::DB_HOST . " successfully.";
        } catch (PDOException $pe) {
            die("Could not connect to the database " . self::DB_NAME . ":" . $pe->getMessage());
        }
        return self::$connection;
    }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    public static function getConnection(): AdvertDatabase
    {
        $db = static::class;
        if (!isset(self::$instances[$db])) {
            self::$instances[$db] = new static();
        }

        return self::$instances[$db];
    }
}
