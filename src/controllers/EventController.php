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
        $events = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Configurer IntlDateFormatter
        $formatter = new \IntlDateFormatter(
            'fr_FR',
            \IntlDateFormatter::FULL,
            \IntlDateFormatter::NONE
        );
        $formatter->setPattern('EEEE'); // Format pour le jour de la semaine

        // Organiser les événements par jour de la semaine
        $organizedEvents = [
            'Lundi' => [],
            'Mardi' => [],
            'Mercredi' => [],
            'Jeudi' => [],
            'Vendredi' => [],
            'Samedi' => [],
            'Dimanche' => []
        ];

        foreach ($events as $event) {
            $dayOfWeek = ucfirst($formatter->format(new \DateTime($event['event_date'])));
            if (isset($organizedEvents[$dayOfWeek])) {
                $organizedEvents[$dayOfWeek][] = $event;
            }
        }

        return $this->twig->render($response, 'events.twig', [
            'events' => $organizedEvents
        ]);
    }

    public function addEvent($request, $response)
    {
        if (!isset($_SESSION['user_id'])) {
            // Redirection si l'utilisateur n'est pas connecté
            return $response->withHeader('Location', '/login')->withStatus(302);
        }

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
