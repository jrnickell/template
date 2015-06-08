<?php

use Silex\Application;

require __DIR__.'/autoload.php';

$paths = require __DIR__.'/paths.php';
$paths['cache'] = $paths['cache'].'/prod';
$paths['logs'] = $paths['logs'].'/prod';

$config = require $paths['config'].'/config.php';

$app = new Application([
    'debug'   => false,
    'version' => $config['version'],
    'paths'   => $paths,
    'config'  => $config
]);

require $app['paths']['config'].'/services.php';
require $app['paths']['config'].'/routes.php';

$app['filesystem']->mkdir([
    $app['paths']['cache'],
    $app['paths']['logs']
]);

return $app;
