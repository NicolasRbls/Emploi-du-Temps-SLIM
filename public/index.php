<?php

session_start(); // Démarrage de la session
setlocale(LC_TIME, 'fr_FR.UTF-8');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use DI\Container;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

require __DIR__ . '/../vendor/autoload.php';

// Create Container
$container = new Container();

// Configure Twig in Container avec le bon chemin
$container->set('view', function() {
    // On utilise le chemin absolu pour être sûr
    $templatesPath = dirname(__DIR__) . '/templates';
    return Twig::create($templatesPath, [
        'cache' => false,
        'debug' => true
    ]);
});

// Create App with Container
AppFactory::setContainer($container);
$app = AppFactory::create();

// Get Twig from container
$twig = $container->get('view');

// Add Twig-View Middleware
$app->add(TwigMiddleware::create($app, $twig));

// Include Routes
(require __DIR__ . '/../src/routes.php')($app);

// Run App
$app->run();