<?php

$bootstrap = dirname(__DIR__).'/app/bootstrap.dev.php';

$app = require $bootstrap;

$app->run();
