<?php
namespace App\Http\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as ServerRequest;
use Slim\Views\Twig;

class IndexController
{
    public function home(ServerRequest $request, Response $response)
    {
        $view = Twig::fromRequest($request);

        return $view->render($response, 'home.twig', ['name' => 'guest']);
    }
}
