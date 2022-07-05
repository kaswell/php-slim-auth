<?php

use App\Controllers\HomeController;
use App\Middlewares\AuthMiddleware;
use Slim\App;

/** @var App $app */
$app->get('/', [HomeController::class, 'home'])->setName('home')->add(AuthMiddleware::class);