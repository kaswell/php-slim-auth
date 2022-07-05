<?php

namespace App\Middlewares;

use Awurth\SlimValidation\Validator;
use Psr\Container\ContainerInterface as Container;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Respect\Validation\Validator as Rules;
use Slim\Psr7\Response;

class LoginMiddleware
{
    /**
     * @var Container
     */
    protected Container $container;


    /**
     * LoginMiddleware constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }


    public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $handler)
    {
        /** @var Validator $validator */
        $validator = $this->container->get(Validator::class)->request($request, [
            'login' =>
                [
                    'rules' => Rules::notBlank(),
                    'messages' => [

                    ]
                ],
            'password' => [
                'rules' => Rules::notBlank(),
            ],
        ]);

        if ($validator->isValid()) {
            return $handler->handle($request);
        } else {
            $response = new Response();

            $response->getBody()->write(json_encode([
                'errors'=>$validator->getErrors(),
            ]));

            return $response->withHeader('Content-Type', 'application/json');
        }
    }
}