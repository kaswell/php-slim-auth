<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class HomeController extends Controller
{
    public function home(Request $request, Response $response, array $args)
    {
        $user = $this->container->get('user');

        return $this->view->render($response, 'home.tpl', [
            'user' => $user,
        ]);
    }
}