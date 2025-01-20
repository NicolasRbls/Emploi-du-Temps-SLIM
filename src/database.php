<?php

function getDatabaseConnection()
{
    // Assure-toi que la base de données est dans un dossier accessible
    $databasePath = __DIR__ . '/../database/database.sqlite';
    
    // Crée un dossier "database" s'il n'existe pas
    if (!file_exists(dirname($databasePath))) {
        mkdir(dirname($databasePath), 0777, true);
    }

    // Retourne la connexion PDO
    $pdo = new PDO('sqlite:' . $databasePath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}
