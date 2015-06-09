<?php

use Silex\Application;

require __DIR__.'/autoload.php';

// paths
$paths = require __DIR__.'/paths.php';
$paths['cache'] = $paths['cache'].'/dev';
$paths['logs'] = $paths['logs'].'/dev';

// application
$app = new Application([
    'debug' => true,
    'paths' => $paths
]);

// configuration
$config = require $app['paths']['config'].'/config_dev.php';
$app['config'] = $config;
$app['version'] = $config['version'];

// services
require $app['paths']['config'].'/services_dev.php';

// routing
require $app['paths']['config'].'/routes_dev.php';

// write directories
$app['filesystem']->mkdir([
    $app['paths']['cache'],
    $app['paths']['logs']
]);

return $app;
