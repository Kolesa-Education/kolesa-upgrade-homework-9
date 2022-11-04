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

    public function showAdvert(ServerRequest $request, Response $response, $args){
        $getAdvertId = $args['id'];
        $getAdvertId = intval($getAdvertId);
        $returnAdvert = new AdvertRepository();
        $newAdd = $returnAdvert->getById($getAdvertId);
        $load = Twig::fromRequest($request);
        return $load->render($response, 'adverts/advert.twig', ['advert' => $newAdd]);   
    }

    public function editAdvert(ServerRequest $request, Response $response, $args){
        $getAdvertId = $args['id'];
        $getAdvertId = intval($getAdvertId);
        $returnAdvert = new AdvertRepository();
        $newAdd = $returnAdvert->getById($getAdvertId);
        $load = Twig::fromRequest($request);
        return $load->render($response, 'adverts/edit.twig', ['advert' => $newAdd]);  
    }

    public function newAdvert(ServerRequest $request, Response $response) {
        return Twig::fromRequest($request)->render($response, 'adverts/new.twig');
    }


    public function update(ServerRequest $request, Response $response){
        $getAdvert = new AdvertRepository();
        $advertData = $request->getParsedBodyParam('advert', []);
        return $response->withRedirect('/adverts/' . $advertData["id"]);
    }
}
