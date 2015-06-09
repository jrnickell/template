<?php

use Sami\Sami;
use Symfony\Component\Finder\Finder;

$paths = require dirname(__DIR__).'/paths.php';

$iterator = Finder::create()
    ->files()
    ->name('*.php')
    ->in($paths['src']);

$options = [
    'theme'     => 'default',
    'title'     => 'Project API',
    'build_dir' => $paths['docapi'],
    'cache_dir' => $paths['cache'].'/dev/sami'
];

return new Sami($iterator, $options);
