<?php

namespace App\Controllers;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface as Container;
use Psr\Container\NotFoundExceptionInterface;
use Slim\Views\PhpRenderer as View;

/**
 * Class Controller
 * @package App\Controllers
 */
class Controller
{
    /**
     * @var Container
     */
    protected Container $container;

    /**
     * @var View
     */
    protected View $view;

    /**
     * Controller constructor.
     * @param Container $container
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct(Container $container)
    {
        $this->container = $container;

        $this->view = $this->container->get(View::class);
    }
}