<?php

require_once __DIR__ . '/../vendor/autoload.php';
// get Database connection
require_once('../src/Connection/sql.php');




use App\Http\Controllers;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

$twig = Twig::create(__DIR__ . '/../templates', ['cache' => false]);
$app  = AppFactory::create();
$app->addErrorMiddleware(true, true, true);
$app->add(TwigMiddleware::create($app, $twig));

$app->get('/', Controllers\IndexController::class . ':home');
$app->get('/adverts', Controllers\AdvertController::class . ':index');
$app->get('/adverts/new', Controllers\AdvertController::class . ':newAdvert');
$app->post('/adverts', Controllers\AdvertController::class . ':create');

//to see adverts one by one
$app->get('/adverts/{id}', Controllers\AdvertController::class . ':advertDetail');
//to edit advert
$app->get('/adverts/{id}/edit', Controllers\AdvertController::class . ':advertEditDisplay');
$app->post('/adverts/{id}/edit', Controllers\AdvertController::class . ':advertEdit');

$app->run();

