<?php

namespace App\Http\Controllers;

use App\Model\Repository\AdvertRepository;
use App\Model\Repository\CategoryRepository;
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


    public function check(ServerRequest $request, Response $response)
    {
        $advertsRepo = new CategoryRepository();
        var_dump($advertsRepo->getConnection());
        return $response->write("Done");
    }



    public function newAdvert(ServerRequest $request, Response $response)
    {
        $view = Twig::fromRequest($request);
        $categoryRepo = new CategoryRepository();
        $categories = $categoryRepo->getAll();

        return $view->render($response, 'adverts/new.twig', [
            'categories' => $categories
        ]);
    }

    public function updateAdvert(ServerRequest $request, Response $response, array $args)
    {
        $repo        = new AdvertRepository();
        $id = intval($args['id']);
        $advertData =  $repo->getById($id);

        $categoryRepo = new CategoryRepository();
        $categories = $categoryRepo->getAll();

        $view = Twig::fromRequest($request);

        return $view->render($response, 'adverts/update.twig', [
            'data' => $advertData->toArray(),
            'categories' => $categories
        ]);
    }

    public function create(ServerRequest $request, Response $response)
    {
        $repo        = new AdvertRepository();
        $advertData  = $request->getParsedBodyParam('advert', []);

        $categoryRepo = new CategoryRepository();
        $categories = $categoryRepo->getAll();

        $categoryData  = $request->getParsedBodyParam('category');
        $categoryDataArr = explode('.', $categoryData);
        $categoryArr = ["id" => $categoryDataArr[0], "name" => $categoryDataArr[1]];
        
        $advertData['category_id'] = $categoryArr["id"];

        $validator = new AdvertValidator();
        $errors    = $validator->validate($advertData);

        if (!empty($errors)) {
            $view = Twig::fromRequest($request);

            return $view->render($response, 'adverts/new.twig', [
                'data'   => $advertData,
                'errors' => $errors,
                'categories' => $categories
            ]);
        }
        

        $repo->create($advertData);

        return $response->withRedirect('/adverts');
    }

    public function update(ServerRequest $request, Response $response, array $args)
    {

        $repo        = new AdvertRepository();
        $advertData  = $request->getParsedBodyParam('advert', []);

        $categoryData  = $request->getParsedBodyParam('category');
        $categoryDataArr = explode('.', $categoryData);
        $categoryArr = ["id" => $categoryDataArr[0], "name" => $categoryDataArr[1]];

        $id = intval($args['id']);
        $advertData['category_id'] = $categoryArr["id"];
        $repo->update($id, $advertData);

        return $response->withRedirect("/adverts/$id");
    }

    public function showAdvert(ServerRequest $request, Response $response, array $args)
    {
        $id = $args['id'];

        $advertsRepo = new AdvertRepository();
        $advert     = $advertsRepo->getById(intval($id)) ?? null;

        if (is_null($advert)) {
            return $response->write("Wrong id");
        }

        $view = Twig::fromRequest($request);


        return $view->render($response, 'adverts/showOne.twig', ['advert' => $advert]);
    }
}
