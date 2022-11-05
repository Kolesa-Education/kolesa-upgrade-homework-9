<?php

$conf = parse_ini_file(__DIR__ . '/../../configs/dbconf.ini');

try {
    $db = new PDO("{$conf['driver']}:host={$conf['host']};dbname={$conf['dbname']}", $conf['username'], $conf['password']);
    $db->exec("CREATE TABLE categories (
        id INTEGER PRIMARY KEY AUTO_INCREMENT,
        title VARCHAR(50) NOT NULL UNIQUE,
        description VARCHAR(255)
    )");
} catch (PDOException $e) {
    echo $e->getMessage();
}