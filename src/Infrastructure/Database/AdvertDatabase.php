<?php

namespace App\Infrastructure\Database;

use App\Model\Entity\Advert;

class AdvertDatabase
{
    private static $db_host;
    private static $db_user;
    private static $db_pass;
    private static $db_name;

    public static $connection;

    protected function __construct() {
    }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    public static function getConnection(): \PDO
    {
        if (isset(self::$connection)) {
            return self;
        }

        self::getCredentials();

        try {
            $fmtConnection = \sprintf("mysql:host=%s;dbname=%s;", self::$db_host, self::$db_name);
            self::$connection = new \PDO($fmtConnection, self::$db_user, self::$db_pass);
        } catch (PDOException $pe) {
            die("Could not connect to the database " . self::$db_name . ":" . $pe->getMessage());
        }

        return self::$connection;
    }

    public static function getCredentials(): void
    {
        $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
        $dotenv->safeLoad();
        self::$db_host = $_ENV['DB_HOST'];
        self::$db_user = $_ENV['DB_USER'];
        self::$db_pass = $_ENV['DB_PASS'];
        self::$db_name = $_ENV['DB_NAME'];
    }
}
