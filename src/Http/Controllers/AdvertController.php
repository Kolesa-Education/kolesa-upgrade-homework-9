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

    public function getAdvert(ServerRequest $request,Response $response, $args){
        $advertID = $args['id'];
        $repo = new AdvertRepository();
        $advert = $repo->getById($advertID);

        $view = Twig::fromRequest($request);

        return $view->render($response,'adverts/singleAdvert.twig',['advert'=>$advert]);
    }

    public function editAdvertView(ServerRequest $request, Response $response, array $args) {
        $advertsRepo = new AdvertRepository();
        $adverts     = $advertsRepo->getViewId($args['id']);
        $view = Twig::fromRequest($request);

        return $view->render($response, 'adverts/edit.twig', ['adverts' => $adverts]);
    }

    public function editAdvert(ServerRequest $request, Response $response) {
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

        $repo->update($advertData);

        return $response->withRedirect('/adverts');
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

        $repo->insert($advertData);

        return $response->withRedirect('/adverts');
    }
}
