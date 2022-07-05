<?php

namespace App\Controllers;

use App\Models\User;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Psr7\Message;

class AuthController extends Controller
{
    /**
     * @return false|Message|\Slim\Psr7\Response
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function logined()
    {
        $session = $this->container->get('session');
        if ($session->exists('user_id')) {
            $user = User::find($session->get('user_id'));
            $this->container->set('user', $user);

            $response = new \Slim\Psr7\Response();
            $url = $this->container->get(App::class)->getRouteCollector()->getNamedRoute('home')->getPattern();
            return $response->withHeader('Location', $url)->withStatus(302);
        }
        return false;
    }


    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     * @throws \Throwable
     */
    public function register(Request $request, Response $response, array $args)
    {
        return ($this->logined()) ? $this->logined() : $this->view->render($response, 'register.tpl', $args);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     * @throws \Throwable
     */
    public function login(Request $request, Response $response, array $args)
    {
        return ($this->logined()) ? $this->logined() : $this->view->render($response, 'login.tpl', $args);
    }


    public function createNewUser(Request $request, Response $response, array $args)
    {
        $data = $request->getParsedBody();

        $user = User::create([
            'login' => $data['login'],
            'password' => $data['password'],
        ]);

        if ($user){
            $url = $this->container->get(App::class)->getRouteCollector()->getNamedRoute('login')->getPattern();
            return $response->withHeader('Location', $url)->withStatus(302);
        }
        return (new \Slim\Psr7\Response())->withHeader('Content-Type', 'application/json')->getBody()->write('Something went wrong');
    }


    public function loginUser(Request $request, Response $response, array $args)
    {
        $data = $request->getParsedBody();

        $user = User::where('login', '=', $data['login'])->first();
        if ($user && password_verify($data['password'], $user->password)){
            $session = $this->container->get('session');
            $session->set('user_id', $user->id);

            $url = $this->container->get(App::class)->getRouteCollector()->getNamedRoute('home')->getPattern();
            return $response->withHeader('Location', $url)->withStatus(302);
        }

        return $this->view->render($response, 'login.tpl', $args);
    }

    public function logout(Request $request, Response $response, array $args)
    {
        $session = $this->container->get('session');
        $session->delete('user_id');

        $url = $this->container->get(App::class)->getRouteCollector()->getNamedRoute('login')->getPattern();
        return $response->withHeader('Location', $url)->withStatus(302);
    }
}