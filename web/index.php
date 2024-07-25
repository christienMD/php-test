<?php

use Slim\Factory\AppFactory;
use DI\Container;

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$config = require 'config.php';

$container = new Container();
$container->set('config', $config);

AppFactory::setContainer($container);
$app = AppFactory::create();

// Add route middleware
$app->addRoutingMiddleware();

// Add error middleware
$app->addErrorMiddleware(true, true, true);

// Define app routes
$app->get('/', function ($request, $response) {
    $response->getBody()->write("Hello world!");
    return $response;
});

// Run app
$app->run();
