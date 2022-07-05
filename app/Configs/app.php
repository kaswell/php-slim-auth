<?php

return [
    'name' => 'PHP Slim',

    'ErrorMiddleware' => [
        'customErrorHandler' => true,
        'displayErrorDetails' => false,
        'logErrors' => false,
        'logErrorDetails' => false,
    ],

    'views' => [
        'folder' => 'Views',

        'layout' => 'layout',
        'extension' => 'tpl',
    ],
];