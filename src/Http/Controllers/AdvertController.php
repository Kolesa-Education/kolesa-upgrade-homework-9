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
    public function __construct(private AdvertRepository $repo)
    {
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function index(ServerRequest $request, Response $response): ResponseInterface
    {
        $adverts = $this->repo->collection();

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
        $advert = $this->repo->find($request->getAttribute('id'));
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
        $this->repo->create($advertData);
        return $response->withRedirect('/adverts');
    }

    public function renderUpdate(ServerRequest $request, Response $response): Response|ResponseInterface
    {
        return Twig::fromRequest($request)->render($response, 'adverts/edit.twig', [
            'id' => $request->getAttribute('id'),
        ]);
    }

    public function update(ServerRequest $request, Response $response): Response|ResponseInterface
    {
        $advertData = $request->getParsedBodyParam('advert', []);

        $validator = new AdvertValidator();
        $errors = $validator->validate($advertData);
        $id = $request->getAttribute('id');
        if (!empty($errors)) {
            return Twig::fromRequest($request)->render($response, 'adverts/edit.twig', [
                'data' => $advertData,
                'errors' => $errors,
                'id' => $id,
            ]);
        }
        $this->repo->update($advertData, $id);
        return $response->withRedirect('/adverts/' . $id);
    }
}
