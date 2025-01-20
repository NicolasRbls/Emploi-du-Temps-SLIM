<?php

use Slim\App;
use Slim\Views\Twig;
use Nicolas\EmploiTemps\Controllers\UserController;
use Nicolas\EmploiTemps\Controllers\EventController;

return function (App $app) {
    // Route pour la page d'accueil
    $app->get('/', function ($request, $response) {
        $view = Twig::fromRequest($request);
        return $view->render($response, 'home.twig');
    });

    // Routes pour l'inscription
    $app->get('/register', function ($request, $response) {
        $view = Twig::fromRequest($request);
        return $view->render($response, 'register.twig');
    });
    $app->post('/register', [UserController::class, 'register']);

    // Routes pour la connexion
    $app->get('/login', function ($request, $response) {
        $view = Twig::fromRequest($request);
        return $view->render($response, 'login.twig');
    });
    $app->post('/login', [UserController::class, 'login']);

    // Routes pour les événements
    $twig = $app->getContainer()->get('view');
    $eventController = new EventController($twig);
    $app->get('/events', [$eventController, 'listEvents']);
    $app->post('/add-event', [$eventController, 'addEvent']);
};
