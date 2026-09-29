<?php
// V1 — Le serveur fabrique toute la page.
// Requête SQL, logique PHP et HTML sont dans le même fichier.
require __DIR__ . '/db.php';

$formations = getDb()
    ->query('SELECT id, titre, description, niveau FROM formations ORDER BY niveau, titre')
    ->fetchAll();

// Petite fonction d'échappement : jamais de donnée brute dans le HTML
function e(string $texte): string
{
    return htmlspecialchars($texte, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Formations — V1 PHP</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Nos formations</h1>
        <p>V1 — page générée par le serveur (PHP + SQLite)</p>
    </header>

    <main class="liste">
        <?php foreach ($formations as $f): ?>
            <article class="card">
                <h2><?= e($f['titre']) ?></h2>
                <p><?= e($f['description']) ?></p>
                <span class="badge"><?= e($f['niveau']) ?></span>
            </article>
        <?php endforeach; ?>
    </main>

    
</body>
</html>
