<?php

$app->get('/', 'novuso_example.controller.home:indexAction')
    ->bind('novuso_example.home.index');
