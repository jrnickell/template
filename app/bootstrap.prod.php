<?php

use Silex\Application;

require __DIR__.'/autoload.php';

// paths
$paths = require __DIR__.'/paths.php';
$paths['cache'] = $paths['cache'].'/prod';
$paths['logs'] = $paths['logs'].'/prod';

// application
$app = new Application([
    'debug' => false,
    'paths' => $paths
]);

// configuration
$config = require $app['paths']['config'].'/config.php';
$app['config'] = $config;
$app['version'] = $config['version'];

// services
require $app['paths']['config'].'/services.php';

// routing
require $app['paths']['config'].'/routes.php';

// write directories
$app['filesystem']->mkdir([
    $app['paths']['cache'],
    $app['paths']['logs']
]);

return $app;
