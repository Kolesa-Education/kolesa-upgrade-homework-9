<?php
namespace App\Model\Repository;
use PDO;
use PDOException;

class Connection
{
    public function con()
    {
        $driver = 'mysql';
        $host = 'localhost';
        $db   = 'kolesaupgrade';
        $user = 'root';
        $pass = '1q2w3e$R';
        $charset = 'utf8';
        $options = [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION];

        try{
        $pdo = new 
        \PDO("$driver:host=$host; dbname=$db; charset=$charset", 
        $user, $pass, $options);
        } catch(PDOExceptions $e) {
            die("Не могу подключится к базе данных");
        }
    }
}