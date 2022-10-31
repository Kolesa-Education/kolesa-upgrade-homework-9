<?php

namespace App\Http\Controllers;

use App\Model\Repository\CategoryRepository;
use Slim\Http\Response;
use Slim\Http\ServerRequest;

class CategoryController extends BaseController
{
    public function __construct()
    {
        $this->repo = new CategoryRepository();
    }

    public function index(ServerRequest $request, Response $response)
    {
        $categories = $this->repo->getAll();

        return $response->withJson(['categories' => $categories]);
    }
}