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
        $query = $request->getQueryParams();
        $search = $query['search'];
        $categoryId = intval($query['category']);
        $advertsRepo = new AdvertRepository();
        $categoryRepo = new CategoryRepository();
        $categories = $categoryRepo->getAll();

        if (!empty($search) && !empty($categoryId)) {
            $adverts = $advertsRepo->searchAdvertsByCategoryId($search, $categoryId);
        } elseif (!empty($categoryId)) {
            $adverts = empty($categoryId)
                ? $advertsRepo->getAll()
                : $advertsRepo->getAdvertsByCategoryId($categoryId);
        } elseif (!empty($search)) {
            $adverts = $advertsRepo->searchAdverts($search);
        } else {
            $adverts = $advertsRepo->getAll();
        }
        $error = '';
        if (empty($adverts)) {
            $adverts = empty($categoryId)
                ? $advertsRepo->getAll()
                : $advertsRepo->getAdvertsByCategoryId($categoryId);
            $error = 'Объявления содержащие слова запроса не найдены';
        }
        $view = Twig::fromRequest($request);
        $params = [
            'adverts' => $adverts,
            'categories' => $categories,
            'query' => $search,
            'categoryId' => $categoryId,
            'error' => $error
        ];

        return $view->render($response, 'adverts/index.twig', $params);
    }

    public function new(ServerRequest $request, Response $response) {
        $view = Twig::fromRequest($request);
        $categoryRepo = new CategoryRepository();
        $categories = $categoryRepo->getAll();

        return $view->render($response, 'adverts/new.twig', ['categories' => $categories]);
    }

    public function create(ServerRequest $request, Response $response)
    {
        $advertsRepo = new AdvertRepository();
        $advertData = $request->getParsedBodyParam('advert', []);
        $advertData['categoryId'] = intval($request->getParsedBodyParam('category', []));
        $categoryRepo = new CategoryRepository();
        $categories = $categoryRepo->getAll();
        $validator = new AdvertValidator();
        $errors = $validator->validate($advertData);

        if (!empty($errors)) {
            $view = Twig::fromRequest($request);

            return $view->render($response, 'adverts/new.twig', [
                'data'   => $advertData,
                'categories' => $categories,
                'errors' => $errors,
            ]);
        }
        $advertsRepo->create($advertData);

        return $response->withRedirect('/adverts');
    }

    public function show(ServerRequest $request, Response $response, $advertId)
    {
        $advertId = $advertId['id'];
        $advertsRepo = new AdvertRepository();
        $advert = $advertsRepo->getAdvertById(intval($advertId));
        $categoryRepo = new CategoryRepository();
        $category = $categoryRepo->getCategoryById($advert->getCategoryId());
        $view = Twig::fromRequest($request);
        $params = [
            'category' => $category,
            'advert' => $advert
        ];

        return $view->render($response, 'adverts/show.twig', $params);
    }

    public function edit(ServerRequest $request, Response $response, $advertId)
    {
        $advertRepo = new AdvertRepository();
        $advertId = $advertId['id'];
        $advert = $advertRepo->getAdvertById(intval($advertId));
        $categoryRepo = new CategoryRepository();
        $categories = $categoryRepo->getAll();
        $formData = [
            'title' => $advert->getTitle(),
            'description' => $advert->getDescription(),
            'price' => $advert->getPrice(),
            'category' => $advert->getCategoryId()
        ];
        $view = Twig::fromRequest($request);
        $params = [
            'advert' => $advert,
            'data' => $formData,
            'categories' => $categories,
            'categoryId' => $advert->getCategoryId()
        ];

        return $view->render($response, 'adverts/edit.twig', $params);
    }

    public function update(ServerRequest $request, Response $response, $advertId)
    {
        $advertId = $advertId['id'];
        $advertsRepo = new AdvertRepository();
        $advertData = $request->getParsedBodyParam('advert', []);
        $advertData['categoryId'] = intval($request->getParsedBodyParam('category', []));
        $validator = new AdvertValidator();
        $errors = $validator->validate($advertData);
        $categoryRepo = new CategoryRepository();
        $categories = $categoryRepo->getAll();

        if (!empty($errors)) {
            $view = Twig::fromRequest($request);

            return $view->render($response, 'adverts/new.twig', [
                'data'   => $advertData,
                'categories' => $categories,
                'errors' => $errors,
            ]);
        }
        $advertsRepo->updateAdvertById($advertId, $advertData);

        return $response->withRedirect('/adverts/' . $advertId);
    }
}
