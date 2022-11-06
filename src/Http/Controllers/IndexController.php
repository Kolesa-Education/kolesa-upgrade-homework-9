<?php

namespace App\Http\Controllers;

use Slim\Http\ServerRequest;
use Slim\Http\Response;
use Slim\Views\Twig;
use App\Model\Repository\DBConnect\Connector;


class IndexController
{
    public function home(ServerRequest $request, Response $response)
    {
        $view = Twig::fromRequest($request);
        return $view->render($response, 'home.twig', ['name' => 'guest']);
    }
}
