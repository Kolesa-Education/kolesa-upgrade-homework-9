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

$app->get('/', Controllers\IndexController::class . ':home');
$app->get('/error', Controllers\IndexController::class . ':error');
$app->get('/adverts', Controllers\AdvertController::class . ':index');
$app->get('/adverts/new', Controllers\AdvertController::class . ':newAdvert');
$app->post('/adverts', Controllers\AdvertController::class . ':create');

$app->get('/adverts/{id}', Controllers\AdvertController::class . ':view');
$app->get('/adverts/{id}/edit', Controllers\AdvertController::class . ':editGet');
$app->post('/adverts/{id}/edit', Controllers\AdvertController::class . ':editPost');

$app->run();