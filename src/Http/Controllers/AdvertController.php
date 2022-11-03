<?php

namespace App\Http\Controllers;
//require_once 'index.php';

use App\Model\Repository\AdvertRepository;
use App\Model\Validators\AdvertValidator;
use Slim\Http\ServerRequest;
use Slim\Http\Response;
use Slim\Views\Twig;
use App\Model\Repository\dbconnect;

class AdvertController
{
    public function index($request, $response)
    {
        $advertsRepo = new AdvertRepository();
        $adverts     = $advertsRepo->getAll();

        $view = Twig::fromRequest($request);
        
        return $view->render($response, 'adverts/index.twig', ['adverts' => $adverts]);
    }
    public function getAdvert($request, $response, $id){
        $repo = new AdvertRepository();
        $advertData = $repo->getId($id['id']);
        $view = Twig::fromRequest($request);
        return $view->render($response, 'adverts/singleAdvert.twig', ['adverts' => $advertData]);
    }
    public function newAdvert($request, $response) {
        $view = Twig::fromRequest($request);

        return $view->render($response, 'adverts/new.twig');
    }

    public function create($request, $response)
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
    // public function view($request, $response){
    //     $result = $pdo->query('SELECT * FROM adverts where id = 1');

    //     while( $row = $result->fetch(PDO::FETCH_ASSOC)){
    //         return sprintf($row['header'].$row['description'].$row['price']);
    //     }
    // }
}
