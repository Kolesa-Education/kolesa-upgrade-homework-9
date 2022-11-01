<?php

namespace App\Http\Controllers;

use App\Model\Repository\AdvertRepository;
use App\Model\Repository\Dbh;
use App\Model\Validators\AdvertValidator;
use Slim\Http\ServerRequest;
use Slim\Http\Response;
use Slim\Views\Twig;

class AdvertController extends Dbh
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

    public function create(ServerRequest $request, Response $response)
    {
        //$repo        = new AdvertRepository();
        $advertData  = $request->getParsedBodyParam('advert', []);

        $validator   = new AdvertValidator();
        $errors      = $validator->validate($advertData);

        if (!empty($errors)) {
            $view = Twig::fromRequest($request);

            return $view->render($response, 'adverts/new.twig', [
                'data'   => $advertData,
                'errors' => $errors,
            ]);
        }

        //$repo->create($advertData);
        $repo->create($advertData);

        return $response->withRedirect('/adverts');
    }

    public function read(ServerRequest $request, Response $response, array $args)
    {
        $advertsRepo = new AdvertRepository();
        $advertId    = $args['id'];
        $advert      = $advertsRepo->read($advertId);
        $view        = Twig::fromRequest($request);

        return $view->render($response, 'adverts/read.twig', ['adverts' => $advert]);
    }

    public function updateAdvert(ServerRequest $request, Response $response, array $args) 
    {
        $advertId  = $args['id'];
        $advert      = $advertsRepo->update($advertId);
        
        $view = Twig::fromRequest($request);

        return $view->render($response, 'adverts/update.twig', ['adverts' => $advert]);
    }

    public function update(ServerRequest $request, Response $response, array $args)
    {
        $advertId         = $args['id'];

        $advertData       = $request->getParsedBodyParam('advert', []);
        $advertData['id'] = $advertId;


        $validator = new AdvertValidator();
        $errors    = $validator->validate($advertData);

        if (!empty($errors)) {
            $view = Twig::fromRequest($request);

            return $view->render($response, 'adverts/update.twig', [
                'data'   => $advertData,
                'errors' => $errors,
            ]);
        }

        $repo->update($advertData);

        return $response->withRedirect('/adverts');
    }

    private function advertMatch()
    {
        $result;
        if ($this->read($this->id))
        {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }

}
