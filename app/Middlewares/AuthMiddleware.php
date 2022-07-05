<?php

namespace App\Middlewares;

use App\Models\User;
use Psr\Container\ContainerInterface as Container;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\App;
use Slim\Psr7\Response;

/**
 * Class AuthMiddleware
 * @package App\Middlewares
 */
class AuthMiddleware
{
    /**
     * @var Container
     */
    protected Container $container;

    /**
     * AuthMiddleware constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function __invoke(Request $request, RequestHandler $handler)
    {
        $session = $this->container->get('session');
        if ($session->exists('user_id')) {
            $user = User::find($session->get('user_id'));
            $this->container->set('user', $user);

            return $handler->handle($request);
        }

        $url = $this->container->get(App::class)->getRouteCollector()->getNamedRoute('register')->getPattern();

        $response = new Response();
        return $response->withHeader('Location', $url)->withStatus(302);
    }
}