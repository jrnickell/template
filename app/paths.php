<?php

$root_dir = dirname(__DIR__);

return [
    'root'     => $root_dir,
    'app'      => $root_dir.'/app',
    'assets'   => $root_dir.'/public/app_assets',
    'bin'      => $root_dir.'/vendor/bin',
    'build'    => $root_dir.'/app/build',
    'cache'    => $root_dir.'/app/cache',
    'config'   => $root_dir.'/app/config',
    'coverage' => $root_dir.'/app/build/coverage',
    'devops'   => $root_dir.'/app/devops',
    'docapi'   => $root_dir.'/app/build/api',
    'logs'     => $root_dir.'/app/logs',
    'public'   => $root_dir.'/public',
    'reports'  => $root_dir.'/app/build/logs',
    'src'      => $root_dir.'/src',
    'test'     => $root_dir.'/test',
    'vendor'   => $root_dir.'/vendor',
    'views'    => $root_dir.'/app/views'
];
