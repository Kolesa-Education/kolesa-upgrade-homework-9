<?php

namespace App\Http\Controllers;

use App\Model\Repository\AdvertRepository;
use App\Model\Validators\AdvertValidator;
use Exception;
use Slim\Http\ServerRequest;
use Slim\Http\Response;
use Slim\Views\Twig;

class AdvertController
{
    private AdvertRepository $repo;
    private ?Exception $dbError = null;

    public function __construct(){
        try {
            $this->repo = new AdvertRepository();
        } catch (Exception $e){
            $this->dbError = $e;
        }
    }

    public function index(ServerRequest $request, Response $response)
    {
        if ($this->dbError !== null){
            return $response->withRedirect('/error');
        }
            $adverts = $this->repo->getAll();

        $view = Twig::fromRequest($request);

        return $view->render($response, 'adverts/index.twig', ['adverts' => $adverts]);
    }

    public function newAdvert(ServerRequest $request, Response $response) {
        $view = Twig::fromRequest($request);

        return $view->render($response, 'adverts/new.twig');
    }

    public function create(ServerRequest $request, Response $response)
    {
        if ($this->dbError !== null){
            return $response->withRedirect('/error');
        }
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

        $this->repo->create($advertData);

        return $response->withRedirect('/adverts');
    }

    public function view(ServerRequest $request, Response $response, $params) {
        if ($this->dbError !== null){
            return $response->withRedirect('/error');
        }
        $adv = $this->repo->getById($params["id"]);
        $view = Twig::fromRequest($request);
        return $view->render($response, 'adverts/view.twig', ['advert' => $adv]);
    }

    public function editGet(ServerRequest $request, Response $response, $params) {
        if ($this->dbError !== null){
            return $response->withRedirect('/error');
        }
        $adv = $this->repo->getById($params["id"]);
        $view = Twig::fromRequest($request);
        return $view->render($response, 'adverts/edit.twig', ['advert' => $adv]);
    }

    public function editPost(ServerRequest $request, Response $response, $params) {
        if ($this->dbError !== null){
            return $response->withRedirect('/error');
        }
        $advertData  = $request->getParsedBodyParam('advert', []);
        $validator = new AdvertValidator();
        $errors    = $validator->validate($advertData);

        if (!empty($errors)) {
            $adv = $this->repo->getById($params["id"]);
            $view = Twig::fromRequest($request);
            return $view->render($response, 'adverts/edit.twig', [
                'advert' => $adv,
                'errors' => $errors
            ]);
        }
        $this->repo->update($advertData, $params["id"]);
        return $response->withRedirect('/adverts/'.$params["id"]);
    }
}
