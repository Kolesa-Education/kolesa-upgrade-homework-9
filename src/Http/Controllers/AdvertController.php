<?php

namespace App\Http\Controllers;

use App\Model\Repository\AdvertRepository;
use App\Model\Validators\AdvertValidator;
use Slim\Http\ServerRequest;
use Slim\Http\Response;
use Slim\Views\Twig;
use App\Model\Entity\Advert;
//use Connection\
class AdvertController
{
    public function index(ServerRequest $request, Response $response)
    {
        global $mysqli;
        $results = [];
        $sql = "SELECT * FROM adverts";
        $result  = mysqli_query($mysqli, $sql);
        if ($result) {
            while( $row = $result->fetch_array())
            {
                $results[] = new Advert($row);
            }
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($mysqli);
        }


        $adverts = $results;

        $view = Twig::fromRequest($request);

        return $view->render($response, 'adverts/index.twig', ['adverts' => $adverts]);
    }

    public function newAdvert(ServerRequest $request, Response $response, array $args) {
        global $mysqli;
        $view = Twig::fromRequest($request);
        // print_r($view);
        
        // $sql = "INSERT INTO adverts(title, description, price) VALUES ('$args[title], '$args[description]', '$args[price]')";

        // $result  = mysqli_query($mysqli, $sql);
        //     if ($result) {
     
        //                     echo "added";
                   
        //     } else {
        //     echo "Error: " . $sql . "<br>" . mysqli_error($mysqli);
        //     }

        return $view->render($response, 'adverts/new.twig');
    }

    public function create(ServerRequest $request, Response $response)
    {
        global $mysqli;
        $repo        = new AdvertRepository();
        $advertData  = $request->getParsedBodyParam('advert', []);
        print_r($advertData);
        $sql = "INSERT INTO adverts(title, description, price) VALUES ('$advertData[title]', '$advertData[description]', '$advertData[price]')";

        $result  = mysqli_query($mysqli, $sql);
            if ($result) {
     
            echo "added";
                   
            } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($mysqli);
            }
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

//to see adverts one by one
    public function advertDetail(ServerRequest $request, Response $response, array $args)
    {
        $view = Twig::fromRequest($request);
        $advertId = $args['id'];
        //print_r($advertId);
        global $mysqli;
        $res;
        $sql = "SELECT * FROM adverts WHERE id = '$advertId'";
        $result  = mysqli_query($mysqli, $sql);
        if ($result) {
            while( $row = $result->fetch_array())
            {
                if($row['id'] || $row['title'] || $row['description'] || $row['price']){
                    $res = array(
                        'id' => $row['id'],
                        'title' => $row['title'],
                        'description' => $row['description'],
                        'price' => $row['price']
                    );
            }
        }
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($mysqli);
        }
   
        $advert = new Advert($res);

        //$repo = new AdvertRepository();
        //$advert = $repo->getAdvertId($advertId);
        return $view->render($response, 'adverts/oneadvert.twig', ['advert' => $advert]);
    }





//to edit adverts
    public function advertEdit(ServerRequest $request, Response $response)
    {
        global $mysqli;
        $repo        = new AdvertRepository();
        $advertData  = $request->getParsedBodyParam('advert', []);
        print_r($advertData);
        $sql = "UPDATE adverts SET title = '$advertData[title]', description = '$advertData[description]' , price = '$advertData[price]' WHERE id = $advertData[id]";

        $result  = mysqli_query($mysqli, $sql);
            if ($result) {
     
            echo "added";
                   
            } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($mysqli);
            }

        $validator = new AdvertValidator();
        $errors    = $validator->validate($advertData);

        if (!empty($errors)) {
            $view = Twig::fromRequest($request);

            return $view->render($response, 'adverts/edit.twig', [
                'advert'   => $advertData,
                'errors' => $errors,
            ]);
        }

        $repo->edit($advertData);

        return $response->withRedirect('/adverts');
    }

    public function advertEditDisplay(ServerRequest $request, Response $response, array $arrayData)
    {
        $view = Twig::fromRequest($request);
        $advertId = $arrayData['id'];
        global $mysqli;
        $res;
        $sql = "SELECT * FROM adverts WHERE id = '$advertId'";
        $result  = mysqli_query($mysqli, $sql);
        if ($result) {
            while( $row = $result->fetch_array())
            {
                if($row['id'] || $row['title'] || $row['description'] || $row['price']){
                    $res = array(
                        'id' => $row['id'],
                        'title' => $row['title'],
                        'description' => $row['description'],
                        'price' => $row['price']
                    );
            }}
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($mysqli);
        }
   
        $advert = new Advert($res);


        return $view->render($response, 'adverts/edit.twig', ['advert' => $advert]);
    }
}

