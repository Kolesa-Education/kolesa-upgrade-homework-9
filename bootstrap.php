<?php

// bootstrap.php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use DI\Container;

require_once __DIR__ . '/vendor/autoload.php';


$container = new Container();

$container->set(EntityManager::class, function (): EntityManager {

    $paths = array(__DIR__ . '/src/Model/Entity');
    $isDevMode = true;

    // the connection configuration
    $dbParams = array(
        'driver' => 'pdo_mysql',
        'host' => 'localhost',
        'port' => 3306,
        'dbname' => 'kolesa',
        'user' => 'root',
        'password' => 'password',
    );

    $config = ORMSetup::createAttributeMetadataConfiguration($paths, $isDevMode);
    $entityManager = EntityManager::create($dbParams, $config);

    return $entityManager;
});

return $container;
