<?php
// Connexion SQLite. La base est créée automatiquement au premier lancement.
function getDb(): PDO
{
    $fichier = __DIR__ . '/data.sqlite';
    $nouvelle = !file_exists($fichier);

    $db = new PDO('sqlite:' . $fichier);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    if ($nouvelle) {
        $db->exec(file_get_contents(__DIR__ . '/init.sql'));
    }
    return $db;
}
