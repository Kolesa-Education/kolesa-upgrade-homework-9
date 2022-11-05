<?php

namespace App\Model\Repository;

use PDO;

class Repository
{
    protected $conn;

    public function __construct(string $pathToConf = __DIR__ . '/../../../configs/dbconf.ini')
    {
        $conf = parse_ini_file($pathToConf);
        $this->conn = new PDO(
            "{$conf['driver']}:host={$conf['host']};dbname={$conf['dbname']}",
            $conf['username'],
            $conf['password']
        );
    }
}