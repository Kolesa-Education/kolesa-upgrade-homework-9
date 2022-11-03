<?php
require_once __DIR__ . '/../vendor/autoload.php'; 

use App\Http\Controllers;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

$twig = Twig::create(__DIR__ . '/../templates', ['cache' => false]);
$app  = AppFactory::create();
$app->addErrorMiddleware(true, true, true);
$app->add(TwigMiddleware::create($app, $twig));

function conect(){
$driver = 'mysql';
$host = 'localhost';
$db   = 'kolesaupgrade';
$user = 'root';
$pass = '1q2w3e$R';
$charset = 'utf8';
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

try{
$pdo = new 
PDO("$driver:host=$host; dbname=$db; charset=$charset", 
$user, $pass, $options);
} catch(PDOExceptions $e) {
    die("Не могу подключится к базе данных");
}
return $pdo;
// $result = $pdo->query('SELECT * FROM adverts');

// while( $row = $result->fetch(PDO::FETCH_ASSOC)){
//     echo $row['header'].$row['description'].$row['price'];
// }
};

$app->get('/', Controllers\IndexController::class . ':home');
$app->get('/adverts', Controllers\AdvertController::class . ':index');
$app->get('/adverts/new', Controllers\AdvertController::class . ':newAdvert');
$app->post('/adverts', Controllers\AdvertController::class . ':create');

$app->get('/adverts/{id}', Controllers\AdvertController::class . ':getAdvert');


$app->run();