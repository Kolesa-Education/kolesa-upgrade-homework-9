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

    public function showAdvert(ServerRequest $request, Response $response)
    {
        $id = (int) $request->getAttribute('id');
        $repo = new AdvertRepository();
        $advert = $repo->getAdvert($id);

        $view = Twig::fromRequest($request);

        return $view->render($response, 'adverts/advert.twig', ['advert' => $advert, 'id' => $id]);
    }

    public function editAdvert(ServerRequest $request, Response $response)
    {
        $view = Twig::fromRequest($request);
        $id = $request->getAttribute('id');
        $repo = new AdvertRepository();
        $advert = $repo->getAdvert($id);

        return $view->render($response, 'adverts/edit.twig', ['data' => $advert, 'id' => $id]);
    }

    public function edit(ServerRequest $request, Response $response)
    {
        $id = $request->getAttribute('id');
        $repo        = new AdvertRepository();
        $advertData  = $request->getParsedBodyParam('advert', []);

        $validator = new AdvertValidator();
        $errors    = $validator->validate($advertData);

        if (!empty($errors)) {
            $view = Twig::fromRequest($request);

            return $view->render($response, 'adverts/edit.twig', [
                'data'   => $advertData,
                'errors' => $errors,
                'id' => $id,
            ]);
        }

        $repo->edit($advertData, $id);

        return $response->withRedirect('/adverts/' . $id);
    }
}