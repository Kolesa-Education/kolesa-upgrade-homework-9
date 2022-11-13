<?php
namespace App\Http\Controllers;

use Psr\Http\Message\ResponseInterface;
use Slim\Http\ServerRequest;
use Slim\Http\Response;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class IndexController
{
    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function home(ServerRequest $request, Response $response): ResponseInterface
    {
        $view = Twig::fromRequest($request);
        return $view->render($response, 'home.twig', ['name' => 'guest']);
    }
}