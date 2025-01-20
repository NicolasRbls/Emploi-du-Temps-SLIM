<?php

require __DIR__ . '/src/database.php';

$pdo = getDatabaseConnection();

// Table des utilisateurs
$pdo->exec("
    CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT UNIQUE NOT NULL,
        password TEXT NOT NULL
    );
");

// Table des événements
$pdo->exec("
    CREATE TABLE IF NOT EXISTS events (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NOT NULL,
        title TEXT NOT NULL,
        description TEXT,
        event_date DATE NOT NULL,
        FOREIGN KEY (user_id) REFERENCES users (id)
    );
");

echo "Database setup complete.";
