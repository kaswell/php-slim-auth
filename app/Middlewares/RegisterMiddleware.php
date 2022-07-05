<?php

namespace App\Middlewares;

use Awurth\SlimValidation\Validator;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface as Container;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Respect\Validation\Validator as Rules;
use Slim\Psr7\Message;
use Slim\Psr7\Response;

/**
 * Class RegisterMiddleware
 * @package App\Middlewares
 */
class RegisterMiddleware
{
    /**
     * @var Container
     */
    protected Container $container;

    /**
     * RegisterMiddleware constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface|Message|Response
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $handler)
    {
        /** @var Validator $validator */
        $validator = $this->container->get(Validator::class)->request($request, [
            'login' =>
                [
                    'rules' => Rules::notBlank()->length(2, 20)->alnum('_')->noWhitespace(),
                    'messages' => [

                    ]
                ],
            'password' => [
                'rules' => Rules::length(5)->alpha()->noWhitespace(),
            ],
            'password_confirmation' => [
                'rules' => Rules::equals($request->getParsedBody()['password']),
                'messages' => [
                    'equals' => 'password_confirmation must be equals password'
                ]
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