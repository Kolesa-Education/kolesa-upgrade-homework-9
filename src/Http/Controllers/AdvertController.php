<?php

namespace App\Http\Controllers;

use App\Model\Repository\AdvertRepository;
use App\Model\Validators\AdvertValidator;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\ServerRequest;
use Slim\Http\Response;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class AdvertController
{
    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function index(ServerRequest $request, Response $response): ResponseInterface
    {
        $advertsRepo = new AdvertRepository();
        $adverts = $advertsRepo->getAll();
        $view = Twig::fromRequest($request);
        return $view->render($response, 'adverts/index.twig', ['adverts' => $adverts]);
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function newAdvert(ServerRequest $request, Response $response): ResponseInterface
    {
        $view = Twig::fromRequest($request);
        return $view->render($response, 'adverts/new.twig');
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function create(ServerRequest $request, Response $response): Response|ResponseInterface
    {
        $repo = new AdvertRepository();
        $advertData = $request->getParsedBodyParam('advert', []);
        $validator = new AdvertValidator();
        $errors = $validator->validate($advertData);
        if (!empty($errors)) {
            $view = Twig::fromRequest($request);
            return $view->render($response, 'adverts/new.twig', [
                'data' => $advertData,
                'errors' => $errors,
            ]);
        }
        $repo->create($advertData);
        return $response->withRedirect('/adverts');
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function getAdvert(ServerRequest $request, Response $response, array $idArray): ResponseInterface
    {
        $advertId = $idArray['id'] ?? 0;
        $advertsRepo = new AdvertRepository();
        $advert = $advertsRepo->getAll($advertId);
        $array = (array)($advert[$advertId-1]);
        $arr = [];
        foreach ($array as $a) {
            $arr[] = $a;
        }
        $view = Twig::fromRequest($request);
        return $view->render($response, 'adverts/advert.twig',
            ['id'=>$arr[0], 'title'=>$arr[1], 'description'=>$arr[2], 'price'=>$arr[3]]);
    }

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function editAdvert(ServerRequest $request, Response $response, $id): Response|ResponseInterface
    {
        $repo = new AdvertRepository();
        $advertData = $request->getParsedBodyParam('advert', []);
        $validator = new AdvertValidator();
        $errors = $validator->validate($advertData);
        if (!empty($errors)) {
            $view = Twig::fromRequest($request);

            return $view->render($response, 'adverts/edit.twig', [
                'data' => $advertData,
                'id' => $id['id'],
                'errors' => $errors,
            ]);
        }
        $repo->edit($advertData, $id['id']);
        return $response->withRedirect('/adverts/' . $id['id']);
    }

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function deleteAdvert(ServerRequest $request, Response $response, $id): Response|ResponseInterface
    {
        $repo = new AdvertRepository();
        $advertData = $request->getParsedBodyParam('advert', []);
        $validator = new AdvertValidator();
        $errors = $validator->validate($advertData);
        if (!empty($errors)) {
            $view = Twig::fromRequest($request);
            return $view->render($response, 'adverts/delete.twig', [
                'data' => $advertData,
                'id' => $id['id'],
                'errors' => $errors,
            ]);
        }
        $repo->deleteAdvert($advertData, $id['id']);
        return $response->withRedirect('/adverts');
    }
}