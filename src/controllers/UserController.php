<?php

namespace Nicolas\EmploiTemps\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

require_once __DIR__ . '/../database.php'; // Inclusion du fichier contenant la fonction

class UserController
{
    private $twig;

    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    public function register($request, $response)
    {
        $data = $request->getParsedBody();
        $username = $data['username'];
        $password = password_hash($data['password'], PASSWORD_DEFAULT);

        $pdo = getDatabaseConnection();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);

        if ($stmt->fetch()) {
            // Nom d'utilisateur déjà utilisé
            $view = Twig::fromRequest($request);
            return $view->render($response, 'register.twig', [
                'error' => "Ce nom d'utilisateur est déjà pris."
            ]);
        }

        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->execute([$username, $password]);

        return $response->withHeader('Location', '/login')->withStatus(302);
    }


    public function login(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $username = $data['username'] ?? '';
        $password = $data['password'] ?? '';

        if (empty($username) || empty($password)) {
            return $response->withHeader('Location', '/login')->withStatus(302);
        }

        $pdo = getDatabaseConnection();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            return $response->withHeader('Location', '/events')->withStatus(302);
        }

        return $response->withHeader('Location', '/login')->withStatus(302);
    }

    public function logout($request, $response)
    {
        session_destroy(); // Détruit la session
        return $response->withHeader('Location', '/login')->withStatus(302); // Redirige vers la page de connexion
    }

}