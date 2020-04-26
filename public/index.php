<?php

declare(strict_types=1);

//use classes
use DI\Container;
use Slim\Factory\AppFactory;
//loading autoload from vendor
require __DIR__ . '/../vendor/autoload.php';
// create container; with $setting, $connection, $logger; the set-up always go like require file then save this requrement into a variable. 
$container = new Container();

$settings = require __DIR__ . '/../app/settings.php';
$settings($container);

$connection = require __DIR__ . '/../app/connection.php';
$connection($container);

$logger = require __DIR__ . '/../app/logger.php';

$logger($container);

// Set Container on app
AppFactory::setContainer($container);

// Create App; with contain $view, $middleware, $routes
$app = AppFactory::create();

$views = require __DIR__ . '/../app/views.php';
$views($app);

$middleware = require __DIR__ . '/../app/middleware.php';
$middleware($app);

$routes = require __DIR__ . '/../app/routes.php';
$routes($app);

// Run App
$app->run();
