<?php

$conf = parse_ini_file(__DIR__ . '/../../configs/dbconf.ini');

try {
    $db = new PDO("{$conf['driver']}:host={$conf['host']};dbname={$conf['dbname']}", $conf['username'], $conf['password']);
    $db->exec("CREATE TABLE adverts (
        id INTEGER PRIMARY KEY AUTO_INCREMENT,
        title VARCHAR(50) NOT NULL,
        description TEXT,
        price INTEGER,
        category_id INTEGER,
        FOREIGN KEY (category_id) REFERENCES categories(id)
            ON UPDATE CASCADE
    )");
} catch (PDOException $e) {
    echo $e->getMessage();
}