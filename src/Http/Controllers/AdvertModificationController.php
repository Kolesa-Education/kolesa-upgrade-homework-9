<?php

namespace App\Http\Controllers;

use App\Model\Repository\AdvertRepository;
use App\Model\Validators\AdvertValidator;
use Slim\Http\ServerRequest;
use Slim\Http\Response;
use Slim\Views\Twig;

class AdvertModificationController
{
    public function index(ServerRequest $request, Response $response, array $args)
    {
        $id = $args['id'];
        $advertsRepo = new AdvertRepository();
        $adverts     = $advertsRepo->getById($id);
        // $adverts     = $adverts->toArray();
        $view = Twig::fromRequest($request);
        $statement = array(
            'id' => $id,
        );
        foreach ($adverts as $key => $value) {
            $statement[$key] = $value;
        }

        return $view->render($response, 'adverts/modify.twig', ['advert' => $statement]);
    }

    public function modify(ServerRequest $request, Response $response, array $args)
    {
        $id = $args['id'];
        $repo        = new AdvertRepository();
        $advertData  = $request->getParsedBodyParam('advert', []);

        $validator = new AdvertValidator();
        $errors    = $validator->validate($advertData);

        if (!empty($errors)) {
            $view = Twig::fromRequest($request);

            return $view->render($response, 'adverts/modify.twig', [
                'data'   => $advertData,
                'errors' => $errors,
            ]);
        }

        $repo->modify($advertData, $id);

        return $response->withRedirect('/adverts'.'/'.$id);
    }
}