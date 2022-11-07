<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Http\Controllers;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use App\Model\Repository\AdvertRepository;
use App\Model\Validators\AdvertValidator;

$twig = Twig::create(__DIR__ . '/../templates', ['cache' => false]);
$app  = AppFactory::create();
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);
$app->add(TwigMiddleware::create($app, $twig));
$app->addRoutingMiddleware();

$app->get('/', function($request, $response){
    $view = Twig::fromRequest($request);

    return $view->render($response, 'home.twig', ['name' => 'guest']);
});

$app->get('/adverts', function($request, $response){
    $advertsRepo = new AdvertRepository();
    $adverts     = $advertsRepo->getAll();

    $view = Twig::fromRequest($request);

    return $view->render($response, 'adverts/index.twig', ['adverts' => $adverts]);
});

$app->get('/adverts/new', function($request, $response){
    $view = Twig::fromRequest($request);

    return $view->render($response, 'adverts/new.twig');
});

$app->get('/adverts', function($request, $response){
    
    $repo        = new AdvertRepository();
    $advertData  = $request->getParsedBodyParam('advert', []);

    $validator = new AdvertValidator();
    $errors    = $validator->validate($advertData);

    if (!empty($errors)) {
        $view = Twig::fromRequest($request);

        return $view->render($response, 'adverts/new.twig', [
            'data'   => $advertData,
            'errors' => $errors,
        ]);
    }

    $repo->create($advertData);

    return $response->withRedirect('/adverts');
});

$app->run();