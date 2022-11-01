<?php

namespace App\Model\Repository;

use PDO;
use PDOException;

class Dbh
{
    protected function connect()
    {
        try {
            $username = "root";
            $password = "7836e37z";
            $dbh = new PDO('mysql:host=localhost;dbname=kolesa_upgrade', $username, $password);
            return $dbh;
        }
        catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
}