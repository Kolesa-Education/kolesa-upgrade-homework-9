<?php

namespace App\Http\Controllers;

use App\Repository\AdvertRepository;
use App\Services\AdvertService;
use App\Validators\AdvertValidator;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Response;
use Slim\Http\ServerRequest;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class AdvertController
{

    private AdvertService $service;

    public function __construct(AdvertService $service)
    {
        $this->service = $service;
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function index(ServerRequest $request, Response $response): ResponseInterface
    {
        $adverts = $this->service->collection();

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
            die(404);
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
        $advertData = $request->getParsedBodyParam('advert', []);

        $validator = new AdvertValidator();
        $errors = $validator->validate($advertData);

        if (!empty($errors)) {
            return Twig::fromRequest($request)->render($response, 'adverts/new.twig', [
                'data' => $advertData,
                'errors' => $errors,
            ]);
        }
        $this->service->create($advertData);
        return $response->withRedirect('/adverts');
    }

    public function update(ServerRequest $request, Response $response): Response|ResponseInterface
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
