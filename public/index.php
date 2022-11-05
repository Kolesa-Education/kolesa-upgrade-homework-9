<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Http\Controllers;
use Slim\Factory\AppFactory;
use Slim\Middleware\MethodOverrideMiddleware;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

$twig = Twig::create(__DIR__ . '/../templates', ['cache' => false]);
$app  = AppFactory::create();
$app->addErrorMiddleware(true, true, true);
$app->add(MethodOverrideMiddleware::class);
$app->add(TwigMiddleware::create($app, $twig));
$router = $app->getRouteCollector()->getRouteParser();

$app->get('/', Controllers\IndexController::class . ':home')->setName('home');

$app->get('/adverts', Controllers\AdvertController::class . ':index')->setName('adverts.index');
$app->get('/adverts/new', Controllers\AdvertController::class . ':new')->setName('adverts.new');
$app->post('/adverts', Controllers\AdvertController::class . ':create')->setName('adverts.store');
$app->get('/adverts/{id}', Controllers\AdvertController::class . ':show')->setName('adverts.show');
$app->get('/adverts/{id}/edit', Controllers\AdvertController::class . ':edit')->setName('adverts.edit');
$app->patch('/adverts/{id}', Controllers\AdvertController::class . ':update')->setName('adverts.update');

$app->get('/categories', Controllers\CategoryController::class . ':index')->setName('categories.index');
$app->get('/categories/new', Controllers\CategoryController::class . ':new')->setName('categories.new');
$app->post('/categories', Controllers\CategoryController::class . ':create')->setName('categories.store');
$app->get('/categories/{id}', Controllers\CategoryController::class . ':show')->setName('categories.show');
$app->get('/categories/{id}/edit', Controllers\CategoryController::class . ':edit')->setName('categories.edit');
$app->patch('/categories/{id}', Controllers\CategoryController::class . ':update')->setName('categories.update');

$app->run();