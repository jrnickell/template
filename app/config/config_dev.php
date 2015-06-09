<?php

$config = require __DIR__.'/config.php';

$config_dev = [
    'monolog' => [
        'monolog.logfile' => $app['paths']['logs'].'/app.log',
        'monolog.level'   => 'INFO',
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

return array_merge($config, $config_dev);
