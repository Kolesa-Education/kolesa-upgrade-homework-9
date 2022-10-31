<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Http\Controllers;
use Dotenv\Dotenv;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$twig = Twig::create(__DIR__ . '/../templates', ['cache' => false]);
$app  = AppFactory::create();
$app->addErrorMiddleware($_ENV['DISPLAY_ERROR_DETAILS'], $_ENV['DISPLAY_ERROR_DETAILS'], $_ENV['DISPLAY_ERROR_DETAILS']);
$app->add(TwigMiddleware::create($app, $twig));

$app->get('/', Controllers\IndexController::class . ':home');
$app->get('/adverts', Controllers\AdvertController::class . ':index');
$app->get('/adverts/new', Controllers\AdvertController::class . ':newAdvert');
$app->post('/adverts', Controllers\AdvertController::class . ':create');

$app->get('/adverts/{id}', Controllers\AdvertController::class . ':show');
$app->get('/adverts/{id}/edit', Controllers\AdvertController::class . ':editAdvert');
$app->post('/adverts/{id}', Controllers\AdvertController::class . ':update');
$app->get('/categories', Controllers\CategoryController::class . ':index');

$app->run();