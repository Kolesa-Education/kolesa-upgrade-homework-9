<?php

namespace App\Http\Controllers;

use App\Model\Repository\AdvertRepository;
use App\Model\Validators\AdvertValidator;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as ServerRequest;
use Slim\Views\Twig;

class AdvertController
{
    public function index(ServerRequest $request, Response $response)
    {
        $advertsRepo = new AdvertRepository();
        $adverts     = $advertsRepo->getAll();

        $view = Twig::fromRequest($request);

        return $view->render($response, 'adverts/index.twig', ['adverts' => $adverts]);
    }

    public function newAdvert(ServerRequest $request, Response $response) {
        $view = Twig::fromRequest($request);

        return $view->render($response, 'adverts/new.twig');
    }

    public function create(ServerRequest $request, Response $response)
    {
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
    }
    
    public function getAdvert(ServerRequest $request, Response $response, array $args)
    {
        $advertsRepo = new AdvertRepository();
        $advertId = $args['id'];
        $advert = $advertsRepo->getById($advertId);

        $view = Twig::fromRequest($request);

        return $view->render($response, 'adverts/advert.twig', ['advert' => $advert]);
    }

    public function edit(ServerRequest $request, Response $response, array $args) {
        $advertsRepo = new AdvertRepository();
        $advertId = $args['id'];
        $advert = $advertsRepo->getById($advertId);

        $view = Twig::fromRequest($request);

        return $view->render($response, 'adverts/edit.twig', ['adverts' => $adverts]);
    }

    public function editAdvert(ServerRequest $request, Response $response)
    {
        $repo        = new AdvertRepository();
        $advertData  = $request->getParsedBodyParam('advert', []);

        $validator = new AdvertValidator();
        $errors    = $validator->validate($advertData);

        if (!empty($errors)) {
            $view = Twig::fromRequest($request);

            return $view->render($response, 'adverts/edit.twig', [
                'data'   => $advertData,
                'errors' => $errors,
            ]);
        }

        $repo->edit($advertData);

        return $response->withRedirect('/adverts');
    }

}
