<?php

namespace App\Http\Controllers;

use App\Model\Repository\AdvertRepository;
use App\Model\Validators\AdvertValidator;
use Slim\Http\ServerRequest;
use Slim\Http\Response;
use Slim\Views\Twig;

class AdvertController {
    public function index(ServerRequest $request, Response $response) {
        $repo = new AdvertRepository();
        $adverts = $repo->getAll();
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

        $validator   = new AdvertValidator();
        $errors      = $validator->validate($advertData);

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

    public function advertPage(ServerRequest $request, Response $response,$idArray) {
        $view = Twig::fromRequest($request);
        $advertId = $idArray['id'];
        $advertsRepo = new AdvertRepository();
        $advert = $advertsRepo->getById($advertId);

        return $view->render($response, 'adverts/advert.twig', ['advert' => $advert]);
    }

    public function edit(ServerRequest $request, Response $response,$id) {
        $repo      = new AdvertRepository();

        $advertData       = $request->getParsedBodyParam('advert', []);

        $validator = new AdvertValidator();
        $errors    = $validator->validate($advertData);

        if (!empty($errors)) {
            $view = Twig::fromRequest($request);

            return $view->render($response, 'adverts/edit.twig', [
                'data'   => $advertData,
                'id'=>$id['id'],
                'errors' => $errors,
            ]);
        }

        $repo->edit($advertData,$id['id']);

        return $response->withRedirect('/adverts'.$id['id']);
    }

    public function advertEdit(ServerRequest $request, Response $response, $id) {
        $advertsRepo = new AdvertRepository();
        $advertData = $advertsRepo->getById($id['id']);
        $view = Twig::fromRequest($request);

        return $view->render($response, 'adverts/edit.twig',['data' => $advertData, 'id' => $id['id']]);
    }
    
    public function deleteAdvert(ServerRequest $request, Response $response,$id) {
        $repo        = new AdvertRepository();
        $advertData  = $request->getParsedBodyParam('advert',[]);

        $validator = new AdvertValidator();
        $errors    = $validator->validate($advertData);

        if (!empty($errors)) {
            $view = Twig::fromRequest($request);

            return $view->render($response, 'adverts/delete.twig', [
                'data'   => $advertData,
                'id'=>$id['id'],
                'errors' => $errors,
            ]);
        }


        $repo->deleteAdvert($advertData,$id['id']);

        return $response->withRedirect('/adverts');
    }

    public function removeAdvert(ServerRequest $request, Response $response, $id) {

        $advertsRepo = new AdvertRepository();
        $advertData = $advertsRepo->getById($id['id']);
        $view = Twig::fromRequest($request);
        
        return $view->render($response, 'adverts/delete.twig',['data' => $advertData, 'id' => $id['id']]);
    }

}
