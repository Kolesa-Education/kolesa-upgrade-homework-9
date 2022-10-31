<?php

namespace App\Http\Controllers;

use App\Model\Repository\AdvertRepository;
use App\Model\Validators\AdvertValidator;
use Exception;
use Slim\Http\ServerRequest;
use Slim\Http\Response;
use Slim\Views\Twig;

class AdvertController extends BaseController
{
    public function __construct()
    {
        $this->repo = new AdvertRepository();
    }

    public function index(ServerRequest $request, Response $response)
    {
        $title = $_GET['title'] ?? '';
        $categoryId = $_GET['category_id'] ?? 0;

        try {
            $adverts = $this->repo->getByCategoryAndTitle($categoryId, $title);
        } catch (Exception $e) {
            echo $e->getMessage();
            $response->withStatus(404);
            die;
        }

        $view = Twig::fromRequest($request);

        return $view->render($response, 'adverts/index.twig', ['adverts' => $adverts]);
    }

    public function show(ServerRequest $request, Response $response, array $args)
    {
        $view = Twig::fromRequest($request);

        $id = (int) $args['id'];

        try {
            $advert = $this->repo->getById($id);
        } catch (Exception $e) {
            echo $e->getMessage();
            $response->withStatus(404);
            die;
        }

        return $view->render($response, 'adverts/show.twig', ['advert' => $advert]);
    }

    public function newAdvert(ServerRequest $request, Response $response) {
        $view = Twig::fromRequest($request);

        return $view->render($response, 'adverts/new.twig');
    }

    public function create(ServerRequest $request, Response $response)
    {
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

        $this->repo->create($advertData);

        return $response->withRedirect('/adverts');
    }

    public function editAdvert(ServerRequest $request, Response $response) {
        $view = Twig::fromRequest($request);

        return $view->render($response, 'adverts/edit.twig');
    }

    public function update(ServerRequest $request, Response $response, array $args) {
        $id = (int) $args['id'];

        $advertData  = $request->getParsedBodyParam('advert', []);
        $advertData['id'] = $id;

        $validator = new AdvertValidator();
        $errors    = $validator->validate($advertData);

        if (!empty($errors)) {
            $view = Twig::fromRequest($request);

            return $view->render($response, 'adverts/edit.twig', [
                'data'   => $advertData,
                'errors' => $errors,
            ]);
        }

        $this->repo->update($advertData);

        return $response->withRedirect('/adverts');
    }
}
