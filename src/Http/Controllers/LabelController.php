<?php

namespace App\Http\Controllers;


use App\Model\Entity\Advert;
use App\Model\Repository\AdvertRepository;
use App\Model\Validators\AdvertValidator;
use Slim\Http\ServerRequest;
use Slim\Http\Response;
use Slim\Views\Twig;

class LabelController
{
    public function labelId(ServerRequest $request, Response $response, array $args)
    {

        $number = $args['args'] ?? '0';
        $advertRepo = new AdvertRepository();

        $advert = $advertRepo->getAll();

        $array = (array)($advert[$number-1]);

        $arr = [];

        foreach ($array as $a) {
            $arr[] = $a;
        }

        $view =Twig::fromRequest($request);

        return $view->render($response, 'adverts/ViewPosts.twig', ['id'=>$arr[0], 'title'=>$arr[1], 'description'=>$arr[2], 'price'=>$arr[3]]);
    }

    public function edit(ServerRequest $request, Response $response, $args)
    {
        $repo = new AdvertRepository();
        $advertData = $request->getParsedBodyParam('advert', []);
        $validator = new AdvertValidator();
        $errors = $validator->validate($advertData);

        if (!empty($errors)) {
            $view = Twig::fromRequest($request);

            return $view->render($response, 'adverts/EditPost.twig', [
                'data' => $advertData,
                'errors' => $errors,
                'id' => $args['args']
            ]);
        }

        $repo->edit($advertData, $args['args']);;
        return $response->withRedirect('/adverts');
    }
}