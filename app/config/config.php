<?php

$params = require __DIR__.'/parameters.php';

$config = [
    'version' => '0.0.1',
    'monolog' => [
        'monolog.logfile' => $paths['logs'].'/app.log',
        'monolog.level'   => 'ERROR',
        'monolog.name'    => 'app'
    ]
];

return array_merge($config, $params);
