<?php

$params = require __DIR__.'/parameters.php';

$config = [
    'version' => '0.0.1',
    'monolog' => [
        'monolog.logfile' => $app['paths']['logs'].'/app.log',
        'monolog.level'   => 'ERROR',
        'monolog.name'    => 'app'
    ],
    'twig'    => [
        'twig.path'    => $app['paths']['views'],
        'twig.options' => [
            'debug' => $app['debug'],
            'cache' => $app['paths']['cache'].'/twig'
        ]
    ]
];

return array_merge($config, $params);
