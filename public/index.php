<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Http\Controllers\AdvertController;
use App\Http\Controllers\IndexController;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

$twig = Twig::create(__DIR__ . '/../templates', ['cache' => false]);
$app  = AppFactory::create();
$app->addErrorMiddleware(true, true, true);
$app->add(TwigMiddleware::create($app, $twig));

$app->get('/', IndexController::class . ':home');
$app->get('/adverts', AdvertController::class . ':index');
$app->get('/adverts/new', AdvertController::class . ':newAdvert');
$app->post('/adverts', AdvertController::class . ':create');
$app->get('/adverts/{id}',AdvertController::class . ':getAdvert');
$app->get('/adverts/{id}/edit', AdvertController::class . ':editAdvertView');
$app->post('/adverts/{id}/edit', AdvertController::class . ':editAdvert');

$app->run();