<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface;
use Fig\Http\Message\StatusCodeInterface;

/**
 * Class NotFoundController
 * @package App\Controllers
 */
class NotFoundController extends Controller
{
    /**
     * @param $app
     * @param \Throwable $exception
     * @param ServerRequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function response($app, \Throwable $exception, ServerRequestInterface $request)
    {
        $response = $app->getResponseFactory()->createResponse(StatusCodeInterface::STATUS_NOT_FOUND);

        return $this->view->render($response, '404.tpl', []);
    }
}