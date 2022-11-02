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

    public function getAdvert(ServerRequest $request, Response $response, $args) {
        $id = $args['id'];
        $view = Twig::fromRequest($request);
        $advertsRepo = new AdvertRepository();
        $advert = $advertsRepo->getAdvertById($id);
        return $view->render($response, 'adverts/info.twig', ['advert' => $advert]);
    }

    public function getEditAdvert(ServerRequest $request, Response $response, $args)
    {
        $id = $args['id'];
        $view = Twig::fromRequest($request);
        $advertsRepo = new AdvertRepository();
        $advert = $advertsRepo->getAdvertById($id);
        return $view->render($response, 'adverts/edit.twig', ['advert' => $advert]);
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

    public function put(ServerRequest $request, Response $response)
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

         $repo->put($advertData);

         return $response->withRedirect('/adverts');
     }
}
