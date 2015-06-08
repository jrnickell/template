<?php

use Silex\Application;

require __DIR__.'/autoload.php';

$paths = require __DIR__.'/paths.php';
$paths['cache'] = $paths['cache'].'/dev';
$paths['logs'] = $paths['logs'].'/dev';

$config = require $paths['config'].'/config_dev.php';

$app = new Application([
    'debug'   => true,
    'version' => $config['version'],
    'paths'   => $paths,
    'config'  => $config
]);

require $app['paths']['config'].'/services_dev.php';
require $app['paths']['config'].'/routes_dev.php';

$app['filesystem']->mkdir([
    $app['paths']['cache'],
    $app['paths']['logs']
]);

return $app;
