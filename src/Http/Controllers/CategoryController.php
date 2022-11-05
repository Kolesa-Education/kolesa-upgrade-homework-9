<?php

namespace App\Http\Controllers;

use App\Model\Repository\{
    CategoryRepository,
    AdvertRepository
};
use App\Model\Validators\AdvertValidator;
use http\Params;
use Slim\Http\ServerRequest;
use Slim\Http\Response;
use Slim\Views\Twig;

class CategoryController
{
    public function index(ServerRequest $request, Response $response)
    {
        $view = Twig::fromRequest($request);
        $dbcon = new CategoryRepository();
        $categories = $dbcon->getAll();

        return $view->render($response, 'categories/index.twig', ['categories' => $categories]);
    }

    public function new(ServerRequest $request, Response $response) {
        $view = Twig::fromRequest($request);
        return $view->render($response, 'categories/new.twig');
    }

    public function create(ServerRequest $request, Response $response)
    {
        $categoryData = $request->getParsedBodyParam('category', []);
        $db = new CategoryRepository();
        $db->create($categoryData);

        return $response->withRedirect('/categories');
    }

    public function show(ServerRequest $request, Response $response, $categoryId)
    {
        $categoryId = $categoryId['id'];
        $db = new CategoryRepository();
        $category = $db->getCategoryById(intval($categoryId));
        $adverts = $db->getAdvertsByCategoryId(intval($categoryId));
        $view = Twig::fromRequest($request);
        $params = [
            'category' => $category,
            'adverts' => $adverts
        ];

        return $view->render($response, 'categories/show.twig', $params);
    }

    public function edit(ServerRequest $request, Response $response, $categoryId)
    {
        $db = new CategoryRepository();
        $categoryId = $categoryId['id'];
        $category = $db->getCategoryById(intval($categoryId));
        $formData = [
            'title' => $category->getTitle(),
            'description' => $category->getDescription()
        ];
        $view = Twig::fromRequest($request);
        $params = [
            'category' => $category,
            'data' => $formData
        ];

        return $view->render($response, 'categories/update.twig', $params);
    }

    public function update(ServerRequest $request, Response $response, $categoryId)
    {
        $categoryId = $categoryId['id'];
        $categoryData = $request->getParsedBodyParam('category', []);
        $db = new CategoryRepository();
        $db->updateCategoryById($categoryId, $categoryData);

        return $response->withRedirect('/categories');
    }
}



















