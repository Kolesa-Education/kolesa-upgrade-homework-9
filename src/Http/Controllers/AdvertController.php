<?php

namespace App\Http\Controllers;

use App\Model\Repository\AdvertRepository;
use App\Model\Validators\AdvertValidator;
use DI\Container;
use Slim\Http\ServerRequest;
use Slim\Http\Response;
use Slim\Views\Twig;
use Doctrine\ORM\EntityManager;

class AdvertController
{

    protected $container;

    // constructor receives container instance
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function index(ServerRequest $request, Response $response)
    {

        $advertsRepo = new AdvertRepository($this->container->get(EntityManager::class));
        $adverts     = $advertsRepo->getAll();
        $view = Twig::fromRequest($request);
        return $view->render($response, 'adverts/index.twig', ['adverts' => $adverts]);
    }

    public function newAdvert(ServerRequest $request, Response $response)
    {
        $view = Twig::fromRequest($request);

        return $view->render($response, 'adverts/new.twig');
    }

    public function create(ServerRequest $request, Response $response)
    {
        $repo        = new AdvertRepository($this->container->get(EntityManager::class));
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
    }

    public function updateAdvert(ServerRequest $request, Response $response, array $args)
    {
        $advertsRepo = new AdvertRepository($this->container->get(EntityManager::class));
        $advert      = $advertsRepo->getAdvert($args["id"]);
        $view = Twig::fromRequest($request);

        return $view->render($response, 'adverts/id.twig', ['advert' => $advert]);
    }

    public function update(ServerRequest $request, Response $response, array $args)
    {
        print_r($args["id"]);
        $repo        = new AdvertRepository($this->container->get(EntityManager::class));
        $advertData  = $request->getParsedBodyParam('advert', []);
        $validator = new AdvertValidator();
        $errors    = $validator->validate($advertData);

        if (!empty($errors)) {
            $view = Twig::fromRequest($request);

            return $view->render($response, 'adverts/id.twig', [
                'data'   => $advertData,
                'errors' => $errors,
            ]);
        }

        $repo->update($advertData, $args["id"]);

        return $response->withRedirect('/adverts');
    }
}
