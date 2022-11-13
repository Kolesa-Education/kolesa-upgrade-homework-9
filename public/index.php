<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Http\Controllers;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Twig\Error\LoaderError;

try {
    $twig = Twig::create(__DIR__ . '/../templates', ['cache' => false]);
} catch (LoaderError $e) {
}
$app  = AppFactory::create();
$app->addErrorMiddleware(true, true, true);
$app->add(TwigMiddleware::create($app, $twig));

$app->get('/', Controllers\IndexController::class . ':home');
$app->get('/adverts', Controllers\AdvertController::class . ':index');
$app->get('/adverts/new', Controllers\AdvertController::class . ':newAdvert');
$app->post('/adverts', Controllers\AdvertController::class . ':create');
$app->get('/adverts/{id}', Controllers\AdvertController::class . ':getAdvert');
$app->get('/adverts/{id}/edit', Controllers\AdvertController::class . ':editAdvert');
$app->post('/adverts/{id}/edit', Controllers\AdvertController::class . ':editAdvert');
$app->get('/adverts/{id}/delete', Controllers\AdvertController::class . ':deleteAdvert');
$app->delete('/adverts/{id}/delete', Controllers\AdvertController::class . ':deleteAdvert');
$app->run();