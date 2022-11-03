<?php

namespace App\Model\Repository\DB;

use PDO;
use PDOException;

class DB
{
    protected $pdo = null;

    public function connectDB()
    {
        define('DB_NAME', 'adverts');
        define('DB_USER', 'root');
        define('DB_PASSWORD', 'mako');
        define('DB_HOST', 'localhost');

        if (is_null($this->pdo)) {
            try {
                $this->pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
            } catch (PDOException $e) {
                print "Error!: " . $e->getMessage();
                die();
            }

            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        }
        
        return $this->pdo;
    }
}
