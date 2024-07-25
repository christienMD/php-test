<?php

use Slim\Factory\AppFactory;
use DI\Container;

require __DIR__ . '/../vendor/autoload.php';

$container = new Container();
AppFactory::setContainer($container);
$app = AppFactory::create();

// middleware
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);

// routes
$app->get('/recipes', 'RecipeController:list');
$app->post('/recipes', 'RecipeController:create');
$app->get('/recipes/{id}', 'RecipeController:get');
$app->put('/recipes/{id}', 'RecipeController:update');
$app->delete('/recipes/{id}', 'RecipeController:delete');
$app->post('/recipes/{id}/rating', 'RecipeController:rate');
$app->get('/recipes/search', 'RecipeController:search');

$app->run();
