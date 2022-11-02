<?php

const CONFIG_PATH = '../src/Model/Repository/db_config.json';
$config = json_decode(file_get_contents(self::CONFIG_PATH), true) ?? [];

return [
    'dbname' => $config["dbName"],
    'user' => $config["username"],
    'password' => $config["password"],
    'host' => $config["host"],
    'driver' => 'pdo_mysql',
];