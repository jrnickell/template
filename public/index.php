<?php

$bootstrap = dirname(__DIR__).'/app/bootstrap.prod.php';

$app = require $bootstrap;

$app->run();
