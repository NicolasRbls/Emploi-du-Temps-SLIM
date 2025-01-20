<?php

namespace Nicolas\EmploiTemps\Controllers;

use Slim\Views\Twig;

class EventController
{
    private $twig;

    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    public function listEvents($request, $response)
    {
        $pdo = getDatabaseConnection();
        $stmt = $pdo->prepare("SELECT * FROM events WHERE user_id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $events = $stmt->fetchAll();

        return $this->twig->render($response, 'events.twig', ['events' => $events]);
    }

    public function addEvent($request, $response)
    {
        $data = $request->getParsedBody();
        $title = $data['title'];
        $description = $data['description'];
        $event_date = $data['event_date'];

        $pdo = getDatabaseConnection();
        $stmt = $pdo->prepare("INSERT INTO events (user_id, title, description, event_date) VALUES (?, ?, ?, ?)");
        $stmt->execute([$_SESSION['user_id'], $title, $description, $event_date]);

        return $response->withHeader('Location', '/events')->withStatus(302);
    }
}
