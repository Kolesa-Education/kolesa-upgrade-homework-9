<?php

namespace App\Http\Controllers;

use App\Model\Repository\AdvertRepository;
use App\Model\Validators\AdvertValidator;
use Slim\Http\ServerRequest;
use Slim\Http\Response;
use Slim\Views\Twig;
use App\Model\Entity\Advert;

class AdvertController
{
    public function index(ServerRequest $request, Response $response)
    {
        $advertsRepo = new AdvertRepository();
        $adverts     = $advertsRepo->getAll();

        $view = Twig::fromRequest($request);

        return $view->render($response, 'adverts/index.twig', ['adverts' => $adverts]);
    }

    public function getAdvertByID(ServerRequest $request, Response $response, array $args)
    {
        $advertsRepo = new AdvertRepository();
        $adverts     = $advertsRepo->getOne($args['id']);

        $view = Twig::fromRequest($request);

        return $view->render($response, 'adverts/indexByID.twig', ['adverts' => $adverts]);
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
    
    public function getEdit(ServerRequest $request, Response $response, array $args) {
        $advertsRepo = new AdvertRepository();
        $adverts     = $advertsRepo->getOne($args['id']);
        $view = Twig::fromRequest($request);

        return $view->render($response, 'adverts/edit.twig', ['adverts' => $adverts]);
    }

    public function postEdit(ServerRequest $request, Response $response, array $args) {
        $repo       = new AdvertRepository();

        $advertData = $request->getParsedBodyParam('advert', []);
        $validator  = new AdvertValidator();
        $errors     = $validator->validate($advertData);

        if (!empty($errors)) {
            $view = Twig::fromRequest($request);

            return $view->render($response, 'adverts/edit.twig', [
                'data'   => $advertData,
                'errors' => $errors,
            ]);
        }
        print_r($args);
        print_r($advertData);
        print_r($args['id']);
        
        $repo->edit($advertData, $args['id']);

        return $response->withRedirect('/adverts');
    }
}
