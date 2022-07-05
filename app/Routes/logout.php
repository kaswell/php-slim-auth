<?php

use App\Controllers\AuthController;
use App\Middlewares\LoginMiddleware;
use Slim\App;

/** @var App $app */
$app->get('/logout', [AuthController::class, 'logout']);
