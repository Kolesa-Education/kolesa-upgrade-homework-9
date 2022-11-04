<?php

namespace App\Http\Controllers;

use App\Model\Repository\AdvertRepository;
use App\Model\Validators\AdvertValidator;
use Slim\Http\ServerRequest;
use Slim\Http\Response;
use Slim\Views\Twig;
use App\Model\Entity\Advert;
use PDOException;

class AdvertController
{
    public function index(ServerRequest $request, Response $response)
    {
        $advertsRepo = new AdvertRepository();
        try {
            $adverts = $advertsRepo->getAll();
        } catch (PDOException $e){
            $errors = array();
            $errors['message'] = $e->getMessage();
            $view = Twig::fromRequest($request);
            return $view->render($response, 'adverts/index.twig', ['errors' => $errors]);
        }

        $view = Twig::fromRequest($request);

        return $view->render($response, 'adverts/index.twig', ['adverts' => $adverts]);
    }

    public function showAdvert(ServerRequest $request, Response $response, $args){
        $advert_id = (int)$args['id'];
        $advertsRepo = new AdvertRepository();
        try{
            $advert = $advertsRepo->getById($advert_id);
        } catch (PDOException $e){
            $errors = array();
            $errors['message'] = $e->getMessage();
            $view = Twig::fromRequest($request);
            return $view->render($response, 'adverts/advert.twig', ['errors' => $errors]);
        }

        $view = Twig::fromRequest($request);

        return $view->render($response, 'adverts/advert.twig', ['advert' => $advert]);
    }

    public function editAdvert(ServerRequest $request, Response $response, $args){
        $advert_id = (int)$args['id'];
        $advertsRepo = new AdvertRepository();
        try{
            $advert = $advertsRepo->getById($advert_id);
        } catch (PDOException $e){
            $errors = array();
            $errors['message'] = $e->getMessage();
            $view = Twig::fromRequest($request);
            return $view->render($response, 'adverts/edit.twig', ['errors' => $errors]);
        }

        $view = Twig::fromRequest($request);

        return $view->render($response, 'adverts/edit.twig', ['advert' => $advert]);
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

    public function update(ServerRequest $request, Response $response){
        $repo        = new AdvertRepository();
        $advertData  = $request->getParsedBodyParam('advert', []);

        $validator = new AdvertValidator();
        $errors    = $validator->validate($advertData);

        if (!empty($errors)) {
            $view = Twig::fromRequest($request);
            $advert = new Advert($advertData);
            return $view->render($response, 'adverts/edit.twig', [
                'advert'   => $advert,
                'errors' => $errors,
            ]);
        }

        $result = $repo->update($advertData);

        if(!$result){
            $view = Twig::fromRequest($request);
            $errors = array();
            array_push($errors, "Something went wrong");
            $advert = new Advert($advertData);
            return $view->render($response, 'adverts/edit.twig', [
                'advert'   => $advert,
                'errors' => $errors,
            ]);
        }

        return $response->withRedirect('/adverts/' . $advertData["id"]);
    }
}
