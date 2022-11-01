<?php

namespace App\Http\Controllers;

use App\Model\Repository\AdvertRepository;
use App\Model\Validators\AdvertValidator;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Response;
use Slim\Http\ServerRequest;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class AdvertController
{
    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function index(ServerRequest $request, Response $response): ResponseInterface
    {
        $advertsRepo = new AdvertRepository();
        $adverts = $advertsRepo->getAll();

        return Twig::fromRequest($request)->render($response, 'adverts/index.twig', ['adverts' => $adverts]);
    }

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function newAdvert(ServerRequest $request, Response $response): ResponseInterface
    {
        return Twig::fromRequest($request)->render($response, 'adverts/new.twig');
    }

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function getItem(ServerRequest $request, Response $response): ResponseInterface
    {
        $advertsRepo = new AdvertRepository();
        $advert = $advertsRepo->find($request->getAttribute('id'));
        if ($advert === null) {
            die(500);
        }
        return Twig::fromRequest($request)->render($response, 'adverts/item.twig', ['advert' => $advert]);
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     * @throws \JsonException
     */
    public function create(ServerRequest $request, Response $response): Response|ResponseInterface
    {
        $repo = new AdvertRepository();
        $advertData = $request->getParsedBodyParam('advert', []);

        $validator = new AdvertValidator();
        $errors = $validator->validate($advertData);

        if (!empty($errors)) {
            return Twig::fromRequest($request)->render($response, 'adverts/new.twig', [
                'data' => $advertData,
                'errors' => $errors,
            ]);
        }
        $repo->create($advertData);
        return $response->withRedirect('/adverts');
    }
}
