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

    public function modify(ServerRequest $request, Response $response, array $args)
    {
        $id = $args['id'];
        $repo        = new AdvertRepository();
        $advertData  = $request->getParsedBodyParam('advert', []);

        $validator = new AdvertValidator();
        $errors    = $validator->validate($advertData);

        if (!empty($errors)) {
            $view = Twig::fromRequest($request);

            return $view->render($response, 'adverts/modify.twig', [
                'data'   => $advertData,
                'errors' => $errors,
            ]);
        }

        $repo->modify($advertData, $id);

        return $response->withRedirect('/adverts'.'/'.$id);
    }

    public function singleAdvert(ServerRequest $request, Response $response, array $args)
    {
        $id = $args['id'] ?? 'error';
        if ($id=='error') {
            return http_response_code(404);
        }
        $advertsRepo = new AdvertRepository();
        $adverts     = $advertsRepo->getById($id);
        $adverts     = $adverts->toArray();
        unset($adverts['id']);
        $view = Twig::fromRequest($request);
        

        return $view->render($response, 'adverts/single.twig', ['advert' => $adverts]);
    }

    public function modifyPage(ServerRequest $request, Response $response, array $args)
    {
        $id = $args['id'] ?? 'error';
        if ($id=='error') {
            return http_response_code(404);
        }
        $advertsRepo = new AdvertRepository();
        $adverts     = $advertsRepo->getById($id);
        $adverts     = $adverts->toArray();
        $view = Twig::fromRequest($request);

        return $view->render($response, 'adverts/modify.twig', ['advert' => $adverts]);
    }
}
