<?php

use App\Controllers\AuthController;
use App\Middlewares\RegisterMiddleware;
use Slim\App;

/** @var App $app */
$app->get('/register', [AuthController::class, 'register'])->setName('register');

$app->post('/register', [AuthController::class, 'createNewUser'])->add(RegisterMiddleware::class);