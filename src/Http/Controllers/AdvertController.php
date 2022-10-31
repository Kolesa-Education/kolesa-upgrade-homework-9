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

//to see adverts one by one
    public function advertDetail(ServerRequest $request, Response $response, array $args)
    {
        $view = Twig::fromRequest($request);
        $advertId = $args['id'];
        $repo = new AdvertRepository();
        $advert = $repo->getAdvertId($advertId);
        return $view->render($response, 'adverts/oneadvert.twig', ['advert' => $advert]);
    }





//to edit adverts
    public function advertEdit(ServerRequest $request, Response $response)
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

    public function advertEditDisplay(ServerRequest $request, Response $response, array $arrayData)
    {
        $view = Twig::fromRequest($request);
        $adId = $arrayData['id'];
        $advertsRepo = new AdvertRepository();
        $advert = $advertsRepo->getAdvertId($adId);


        return $view->render($response, 'adverts/edit.twig', ['advert' => $advert]);
    }
}

