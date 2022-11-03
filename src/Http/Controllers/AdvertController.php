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

    public function view(ServerRequest $request, Response $response, $params) {
        $advertsRepo = new AdvertRepository();
        $adv = $advertsRepo->getById($params["id"]);
        $view = Twig::fromRequest($request);
        return $view->render($response, 'adverts/view.twig', ['advert' => $adv]);
    }

    public function edit_GET(ServerRequest $request, Response $response, $params) {
        $advertsRepo = new AdvertRepository();
        $adv = $advertsRepo->getById($params["id"]);
        $view = Twig::fromRequest($request);
        return $view->render($response, 'adverts/edit.twig', ['advert' => $adv]);
    }

    public function edit_POST(ServerRequest $request, Response $response, $params) {
        $advertsRepo = new AdvertRepository();
        $advertData  = $request->getParsedBodyParam('advert', []);
        $validator = new AdvertValidator();
        $errors    = $validator->validate($advertData);

        if (!empty($errors)) {
            $view = Twig::fromRequest($request);
            return $view->render($response, 'adverts/new.twig', [
                'errors' => $errors,
            ]);
        }
        $advertsRepo->update($advertData, $params["id"]);
        return $response->withRedirect('/adverts/'.$params["id"]);
    }
}
