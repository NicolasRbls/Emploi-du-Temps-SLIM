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

    public function listEvents($request, $response, $args)
    {
        $pdo = getDatabaseConnection();

        // Calculer les dates de début et de fin de la semaine en cours
        $currentDate = isset($args['week']) ? new \DateTimeImmutable($args['week']) : new \DateTimeImmutable();
        $startOfWeek = $currentDate->modify(('Monday' === $currentDate->format('l') ? 'this' : 'last') . ' Monday');
        $endOfWeek = $startOfWeek->modify('+6 days');

        // Récupérer les événements pour cette semaine
        $stmt = $pdo->prepare("SELECT * FROM events WHERE user_id = ? AND event_date BETWEEN ? AND ?");
        $stmt->execute([$_SESSION['user_id'], $startOfWeek->format('Y-m-d'), $endOfWeek->format('Y-m-d')]);
        $events = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Organiser les événements par jour
        $organizedEvents = [];
        $formatter = new \IntlDateFormatter('fr_FR', \IntlDateFormatter::FULL, \IntlDateFormatter::NONE);
        for ($i = 0; $i < 7; $i++) {
            $date = $startOfWeek->modify("+{$i} days");
            $organizedEvents[$date->format('Y-m-d')] = [
                'label' => ucfirst($formatter->format($date)),
                'events' => array_filter($events, fn($event) => $event['event_date'] === $date->format('Y-m-d'))
            ];
        }

        return $this->twig->render($response, 'events.twig', [
            'events' => $organizedEvents,
            'currentWeek' => $startOfWeek->format('Y-m-d'),
            'nextWeek' => $startOfWeek->modify('+7 days')->format('Y-m-d'),
            'previousWeek' => $startOfWeek->modify('-7 days')->format('Y-m-d')
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
