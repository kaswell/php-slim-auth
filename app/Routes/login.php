<?php

use App\Controllers\AuthController;
use App\Middlewares\LoginMiddleware;
use Slim\App;

/** @var App $app */
$app->get('/login', [AuthController::class, 'login'])->setName('login');

$app->post('/login', [AuthController::class, 'loginUser'])->add(LoginMiddleware::class);