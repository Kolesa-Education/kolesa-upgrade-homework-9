<?php

namespace App\Http\Controllers;

use App\Model\Repository\AdvertRepository;
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

    public function newAdvert(ServerRequest $request, Response $response) {
        $view = Twig::fromRequest($request);

        return $view->render($response, 'adverts/new.twig');
    }

    public function updateAdvert(ServerRequest $request, Response $response, array $id) {
        $repo        = new AdvertRepository();
        $id = intval(join('', $id));
        $advertData =  $repo->getById($id);
        $view = Twig::fromRequest($request);

        return $view->render($response, 'adverts/update.twig', [
            'data' => $advertData->toArray(),
        ]);
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

    public function update(ServerRequest $request, Response $response, array $id){
        $repo        = new AdvertRepository();
        $advertData  = $request->getParsedBodyParam('advert', []);
        $id = intval(join('', $id));
        $advertData['id'] = $id;

        $validator = new AdvertValidator();
        $errors    = $validator->validate($advertData);

        if (!empty($errors)) {
            $view = Twig::fromRequest($request);

            return $view->render($response, 'adverts/new.twig', [
                'data'   => $advertData,
                'errors' => $errors,
            ]);
        }
        $repo->update($id, $advertData);

        return $response->withRedirect("/adverts/$id");
    }

    public function showAdvert(ServerRequest $request, Response $response, array $id){
        if(count($id)<1 || count($id)>1){
            return $response->write("Something wrong with parameters...");
        }

        $advertsRepo = new AdvertRepository();
        $advert     = $advertsRepo->getById(intval(join('', $id)))??null;

        if(is_null($advert)){
            return $response -> write("Wrong id");
        }

        $view = Twig::fromRequest($request);


        return $view->render($response, 'adverts/showOne.twig', ['advert'=>$advert]);

    }
}
