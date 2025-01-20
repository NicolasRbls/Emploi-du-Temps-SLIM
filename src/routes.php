<?php

use Slim\App;
use Slim\Views\Twig;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Nicolas\EmploiTemps\Controllers\UserController;
use Nicolas\EmploiTemps\Controllers\EventController;

return function (App $app) {
    // Récupérer Twig depuis le container de manière sécurisée
    $container = $app->getContainer();
    if (!$container) {
        throw new RuntimeException('Container not found');
    }
    
    $twig = $container->get('view');

    $app->get('/', function (Request $request, Response $response) {
        $view = Twig::fromRequest($request);
        return $view->render($response, 'home.twig');
    });

    $app->get('/register', function (Request $request, Response $response) {
        $view = Twig::fromRequest($request);
        return $view->render($response, 'register.twig');
    });

    // Initialiser les contrôleurs avec Twig
    $userController = new UserController($twig);
    $eventController = new EventController($twig);

    // Routes pour les utilisateurs
    $app->post('/register', [$userController, 'register']);
    
    $app->get('/login', function (Request $request, Response $response) {
        $view = Twig::fromRequest($request);
        return $view->render($response, 'login.twig');
    });
    
    $app->post('/login', [$userController, 'login']);

    // Routes pour les événements
    $app->get('/events', [$eventController, 'listEvents']);
    $app->post('/add-event', [$eventController, 'addEvent']);
};