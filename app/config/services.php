<?php

// controllers
$app['novuso_example.controller.home'] = $app->share(function ($app) {
    return new Novuso\Example\Controller\HomeController($app['twig']);
});

// filesystem
$app['filesystem'] = $app->share(function () {
    return new Symfony\Component\Filesystem\Filesystem();
});

// monolog
$app->register(new Silex\Provider\MonologServiceProvider(), $app['config']['monolog']);

// service controllers
$app->register(new Silex\Provider\ServiceControllerServiceProvider());

// doctrine dbal
$app->register(new Silex\Provider\DoctrineServiceProvider(), $app['config']['dbal']);

// twig templating engine
$app->register(new Silex\Provider\TwigServiceProvider(), $app['config']['twig']);
