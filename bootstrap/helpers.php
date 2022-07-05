<?php

if (!defined('BASE_DIR')) exit('No direct script access allowed');

use Symfony\Component\VarDumper\VarDumper;

if (!function_exists('dd')) {
    function dd(...$vars): void
    {
        if (!in_array(\PHP_SAPI, ['cli', 'phpdbg'], true) && !headers_sent()) {
            header('HTTP/1.1 500 Internal Server Error');
        }

        foreach ($vars as $v) {
            VarDumper::dump($v);
        }

        exit(1);
    }
}


if (!function_exists('base_path')) {
    function base_path(string $path = ''): string
    {
        $path = BASE_DIR . trim($path, '/');

        return is_dir($path) ? $path . DIRECTORY_SEPARATOR : $path;
    }
}

if (!function_exists('app_path')) {
    function app_path(string $path = ''): string
    {
        $path = base_path('app') . trim($path, '/');

        return is_dir($path) ? $path . DIRECTORY_SEPARATOR : $path;
    }
}

if (!function_exists('view')) {
    function view()
    {
        global $app;
        return $app->getContainer()->get(\Slim\Views\PhpRenderer::class);
    }
}