<?php

namespace Nicolas\EmploiTemps\Controllers;

use Slim\Psr7\Response;

class UserController
{
    public function register($request, $response)
    {
        $data = $request->getParsedBody();
        $username = $data['username'];
        $password = password_hash($data['password'], PASSWORD_DEFAULT);

        $pdo = getDatabaseConnection();
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->execute([$username, $password]);

        return $response->withHeader('Location', '/login')->withStatus(302);
    }

    public function login($request, $response)
    {
        $data = $request->getParsedBody();
        $username = $data['username'];
        $password = $data['password'];

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
}
