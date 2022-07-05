<?php

use Awurth\SlimValidation\Validator;
use Core\Config;
use Slim\Factory\AppFactory;
use DI\Container;
use Slim\Views\PhpRenderer;

AppFactory::setContainer($container = new Container());

$app = AppFactory::create();
$app->addErrorMiddleware(true, true, true);

$config = new Config();
foreach (glob(app_path('Configs') . '/*.php') as $file) {
    $config->set(basename($file, '.php'), require_once $file);
}
$container->set(get_class($config), $config);

if ($config->has('database')) {
    require_once __DIR__ . '/eloquent.php';
}

foreach (glob(app_path('Routes') . '/*.php') as $file) {
    require_once $file;
}


if ($config->has('middlewares')) {
    foreach ($config->get('middlewares') as $middleware) {
        $app->add($middleware);
    }
}

$container->set(Validator::class, new Validator());


function getRenderer($config)
{
    $renderer = new PhpRenderer();

    $renderer->setTemplatePath(app_path($config['views']['folder']));
    $renderer->setLayout($config['views']['layout'] . '.' . $config['views']['extension']);
    $renderer->setAttributes([
        'title' => $config['name']
    ]);

    return $renderer;
}

$container->set(PhpRenderer::class, getRenderer($config->get('app')));

$app->add(new \Slim\Middleware\Session());
$container->set('session', new \SlimSession\Helper());

$container->set(\Slim\App::class, $app);

$app->run();