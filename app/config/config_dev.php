<?php

$config = require __DIR__.'/config.php';

$config_dev = [
    'monolog' => [
        'monolog.logfile' => $app['paths']['logs'].'/app.log',
        'monolog.level'   => 'INFO',
        'monolog.name'    => 'app'
    ]
];

return array_merge($config, $config_dev);
