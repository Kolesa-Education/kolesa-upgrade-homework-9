<?php

namespace App\Http\Controllers;

use App\Model\DB\Db;
use App\Model\Entity\Advert;
use App\Model\Repository\AdvertRepository;
use App\Model\Validators\AdvertValidator;
use App\Store\MySql\Store;
use Slim\Http\ServerRequest;
use Slim\Http\Response;
use Slim\Views\Twig;


class AdvertController
{
    
    public function index(ServerRequest $request, Response $response){
        $db = new Db;
        $repo = new Store($db);
        $adverts = $repo->getAll();
        
        $view = Twig::fromRequest($request);

        return $view->render($response, 'adverts/index.twig', ['adverts' => $adverts, 'editable'=>true]);

    }

    public function getById(ServerRequest $request, Response $response, $args){
        $db = new Db;
        $repo = new Store($db);
        
        $id = $args['id'];
        if (!is_numeric($id)){
            return  $response->withStatus(400)
            ->withHeader('Content-Type', 'text/html')
            ->write('400 Bad request: the query must be integer');
        }
        
        $adverts = $repo->getByID($id);
        if (empty($adverts)){
            return  $response->withStatus(404)
            ->withHeader('Content-Type', 'text/html')
            ->write('404 Not Found');
        }

        $view = Twig::fromRequest($request);
        return $view->render($response, 'adverts/index.twig', ['adverts' => $adverts]);
    }

    public function newAdvert(ServerRequest $request, Response $response) {
        $db = new Db;
        $repo = new Store($db);
        $categories = $repo->getCategories();

        $view = Twig::fromRequest($request);

        return $view->render($response, 'adverts/new.twig',['categories' => $categories]);
    }

    public function create(ServerRequest $request, Response $response)
    {
        $db = new Db;
        $repo = new Store($db);
        $advertData  = $request->getParsedBodyParam('advert', []);

        $validator = new AdvertValidator();
        $errors    = $validator->validate($advertData);

        if (!empty($errors)) {
            $categories = $repo->getCategories();
            $view = Twig::fromRequest($request);

            return $view->render($response, 'adverts/new.twig', [
                'data'   => $advertData,
                'errors' => $errors,
                'categories' => $categories
            ]);
        }

        $advert = new Advert($advertData);
        $repo->createAdvert($advert);

        return $response->withRedirect('/adverts');
    }

    public function editAdvert(ServerRequest $request, Response $response, $args) {
        $db = new Db;
        $repo = new Store($db);

        $id = $args['id'];
        if (!is_numeric($id)){
            return  $response->withStatus(404)
            ->withHeader('Content-Type', 'text/html')
            ->write('404 Not Found');
        }

        $adverts = $repo->getByID($id);
        if (empty($adverts)){
            return  $response->withStatus(404)
            ->withHeader('Content-Type', 'text/html')
            ->write('404 Not Found');
        }

        $categories = $repo->getCategories();

        $view = Twig::fromRequest($request);
        return $view->render($response, 'adverts/edit.twig', [
            'data'   => $adverts[0],
            'categories' => $categories,
        ]);
    }

    public function update(ServerRequest $request, Response $response, $args){
        $db = new Db;
        $repo = new Store($db);

        $id= $args['id'];
        $advertData  = $request->getParsedBodyParam('advert', []);
        $categories = $repo->getCategories();

        $validator = new AdvertValidator();
        $errors    = $validator->validate($advertData);

        
        if (!empty($errors)) {
            $view = Twig::fromRequest($request);
            $advertData['id']= $id;
            $advertData['category']=  $advertData['ctry_name'];
            return $view->render($response, 'adverts/edit.twig', [
                'data'   => $advertData,
                'errors' => $errors,
                'categories' => $categories,
            ]);
        }

        $advert = new Advert($advertData);
        $repo->updateAdvert($id, $advert);

        return $response->withRedirect('/adverts');
    }
}