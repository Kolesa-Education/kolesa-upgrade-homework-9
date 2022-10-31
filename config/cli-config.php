<?php
require 'vendor/autoload.php';

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Configuration\Migration\PhpFile;
use Doctrine\Migrations\Configuration\Connection\ExistingConnection;

$paths = ['src/Model/Entity'];
$isDevMode = true;
$connection = array(
    "dbname"=>"AdvertsDB",
    "user"=>"root",
    "password"=>"Applejesus$#1",
    "host"=>"localhost",
    "driver"=>"pdo_mysql"

);
$config = new PhpFile('migrations.php');

$ORMconfig = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode, null, null, false);
$entityManager = EntityManager::create($connection, $ORMconfig);
return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);
//return DependencyFactory::fromEntityManager($config, new ExistingEntityManager($entityManager));

