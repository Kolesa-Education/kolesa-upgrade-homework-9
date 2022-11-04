<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Http\Controllers;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use FaaPz\PDO\Database;
use Psr\Container\ContainerInterface;


$twig = Twig::create(__DIR__ . '/../templates', ['cache' => false]);
$app  = AppFactory::create();
$app->addErrorMiddleware(true, true, true);
$app->add(TwigMiddleware::create($app, $twig));

$app->get('/', Controllers\IndexController::class . ':home');
$app->get('/adverts', Controllers\AdvertController::class . ':index');
$app->get('/adverts/new', Controllers\AdvertController::class . ':newAdvert');
$app->post('/adverts', Controllers\AdvertController::class . ':create');

$app->get('/adverts/{id}', Controllers\AdvertController::class . ':singleAdvert');

$app->get('/adverts/{id}/edit', Controllers\AdvertModificationController::class . ':index');
$app->post('/adverts/{id}/edit', Controllers\AdvertModificationController::class . ':modify');

$app->run();

// $container = $app->getContainer();

// $host = '127.0.0.1';
// $db   = 'adverts';
// $user = 'root';
// $port = "3307";
// $pass = 'Miracle.1208';
// $charset = 'utf8mb4';

// $options = [
//     PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
//     PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
//     PDO::ATTR_EMULATE_PREPARES   => false,
// ];
// $dsn = "mysql:host=$host;dbname=$db;charset=$charset;port=$port";
// // try {
// //      $pdo = new \PDO($dsn, $user, $pass, $options);
// // } catch (\PDOException $e) {
// //      throw new \PDOException($e->getMessage(), (int)$e->getCode());
// // }

// $container->set('db', function ($c) {
//     $pdo = new \PDO($dsn, $user, $pass, $options);
//     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//     $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
//     return $pdo;
// });
  
// $pdo = $app->getContainer();
// $pdo = $pdo->get('db');
// $stmt = $pdo->query('SELECT * FROM adverts');

// echo $stmt;