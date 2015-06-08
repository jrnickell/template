<?php

// ============================== //
// REMOVE THIS FILE IN PRODUCTION //
// ============================== //
if (isset($_SERVER['HTTP_CLIENT_IP'])
    || isset($_SERVER['HTTP_X_FORWARDED_FOR'])
    || !(!filter_var(@$_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE)
        || in_array(@$_SERVER['REMOTE_ADDR'], array('fe80::1', '::1'))
    || php_sapi_name() === 'cli-server')) {
    header('HTTP/1.0 403 Forbidden');
    exit('You are not allowed to access this file.');
}

$bootstrap = dirname(__DIR__).'/app/bootstrap.dev.php';

$app = require $bootstrap;

$app->run();
