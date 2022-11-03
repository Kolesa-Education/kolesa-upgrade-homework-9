<?php

namespace App\Http\Controllers;

use App\Model\Repository\AdvertRepository;
use App\Model\Validators\AdvertValidator;
use Slim\Http\ServerRequest;
use Slim\Http\Response;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class AdvertController
{
    public function index(ServerRequest $request, Response $response)
    {
        $db = new AdvertRepository();
        try {
            $adverts     = $db->getAll();
            $view = Twig::fromRequest($request);
            return $view->render($response, 'adverts/index.twig', ['adverts' => $adverts]);
        }catch (PDOException $e){
            $error = array(
                "message" => $e->getMessage()
            );

            $response->getBody()->write(json_encode($error));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(500);
        }
    }

    public function newAdvert(ServerRequest $request, Response $response) {
        $view = Twig::fromRequest($request);
        try {
            $db = new AdvertRepository();
            $categories = $db -> getCategories();
            return $view->render($response, 'adverts/new.twig',['categories' => $categories]);
        }catch (PDOException $e){
            $error = array(
                "message" => $e->getMessage()
            );
            $response->getBody()->write(json_encode($error));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(500);
        }
    }

    public function create(ServerRequest $request, Response $response)
    {

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
        $db = new AdvertRepository();
        try {
            $db->create($advertData);
            return $response->withHeader('content-type', 'application/json')
                ->withStatus(200)->withRedirect('/adverts');
        }catch (PDOException $e){
            $error = array(
                "message" => $e->getMessage()
            );
            $response->getBody()->write(json_encode($error));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(500);
        }
    }

    public function advert(ServerRequest $request, Response $response)
    {
        $id = $request->getAttribute('id');
        $db = new AdvertRepository();
        try {
            $advert =  $db->getById((int)$id);
            $view = Twig::fromRequest($request);
            return $view->render($response, 'adverts/advert.twig', ['advert' => $advert]);
        }catch (PDOException $e){
            $error = array(
                "message" => $e->getMessage()
            );

            $response->getBody()->write(json_encode($error));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(500);
        }

    }

    public function getUpdateAdvert(ServerRequest $request, Response $response){
        $id = $request->getAttribute('id');
        $db = new AdvertRepository();
        try {
            $advert =  $db->getById((int)$id);
            $view = Twig::fromRequest($request);
            return $view->render($response, 'adverts/update.twig', ['advert' => $advert]);
        }catch (PDOException $e) {
            $error = array(
                "message" => $e->getMessage()
            );

            $response->getBody()->write(json_encode($error));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(500);
        }
    }

    public function updateAdvert(ServerRequest $request, Response $response)
    {
        $advertData  = $request->getParsedBodyParam('advert', []);
        $validator = new AdvertValidator();
        $errors    = $validator->validate($advertData);

        if (!empty($errors)) {
            $view = Twig::fromRequest($request);

            return $view->render($response, 'adverts/update.twig', [
                'advert'   => $advertData,
                'data'   => $advertData,
                'errors' => $errors,
            ]);
        }
        $db = new AdvertRepository();
        try {
            $db->update($advertData);
            return $response->withHeader('content-type', 'application/json')
                ->withStatus(200)->withRedirect('/adverts/'.$advertData["id"]);
        }catch (PDOException $e){
            $error = array(
                "message" => $e->getMessage()
            );
            $response->getBody()->write(json_encode($error));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(500);
        }
    }
}
