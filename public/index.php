<?php

use DI\Container;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

require __DIR__ . '/../vendor/autoload.php';

// Configure Container
$container = new Container();
$container->set('view', function () {
    return Twig::create(__DIR__ . '/../templates', ['cache' => false]);
});


AppFactory::setContainer($container);

// Create App
$app = AppFactory::create();

// Add Twig Middleware
$app->add(TwigMiddleware::createFromContainer($app, 'view'));
if (!$container->has('view')) {
    throw new RuntimeException("Twig n'est pas configuré dans le conteneur.");
}

// Include Routes
(require __DIR__ . '/../src/routes.php')($app);

// Run App
$app->run();
