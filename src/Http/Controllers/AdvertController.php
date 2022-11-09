<?php

namespace App\Http\Controllers;

use App\Model\Repository\AdvertRepository;
use App\Model\Validators\AdvertValidator;
use Slim\Http\ServerRequest;
use Slim\Http\Response;
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

    public function newAdvert(ServerRequest $request, Response $response)
    {
        $view = Twig::fromRequest($request);

        return $view->render($response, 'adverts/new.twig');
    }

    public function advertEdit(ServerRequest $request, Response $response, array $args)
    {
        $view = Twig::fromRequest($request);
        $errors = [];

        $adId = $args['id'];
        if (!is_numeric($adId)) {
            return $response->write('Объявление не найдено.');
        }
        $advertsRepo = new AdvertRepository();
        $advert = $advertsRepo->getById($adId);
        if ($advert === null) {
            $errors = ['title' => 'Объявление не найдено.'];
        }
        return $view->render($response, 'adverts/edit.twig', [
            'advert' => $advert,
            'errors' => $errors,
        ]
        );
    }

    public function advertPage(ServerRequest $request, Response $response, array $args)
    {
        $view = Twig::fromRequest($request);
        $adId = $args['id'];
        $advertsRepo = new AdvertRepository();
        $advert = $advertsRepo->getById($adId);
        if ($advert === null) {
            return $response->write('Объявление не найдено.');
        }
        return $view->render($response, 'adverts/advert.twig', ['advert' => $advert]);
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

    public function edit(ServerRequest $request, Response $response)
    {
        $repo        = new AdvertRepository();
        $advertData  = $request->getParsedBodyParam('advert', []);

        $validator = new AdvertValidator();
        $errors    = $validator->validate($advertData);

        if (!empty($errors)) {
            $view = Twig::fromRequest($request);

            return $view->render($response, 'adverts/edit.twig', [
                'advert'   => $advertData,
                'errors' => $errors,
            ]);
        }

        $repo->edit($advertData);

        return $response->withRedirect('/adverts');
    }
    
    public function delete(ServerRequest $request, Response $response, array $args)
    {
        $repo = new AdvertRepository();

        $adId = $args['id'];
        $repo->delete($adId);

        return $response->withRedirect('/adverts');
    }
}
