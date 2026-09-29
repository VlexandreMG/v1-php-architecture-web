<?php
// Remplit la base pour le test de charge V1 / V2.
//
//   php seed.php            → ajoute 10 000 lignes
//   php seed.php 50000      → ajoute 50 000 lignes
//   php seed.php reset      → supprime la base (retour aux 6 formations)
//
// Pour comparer avec une autre version, copier la base :
//   cp data.sqlite ../<autre-version>/
require __DIR__ . '/db.php';

$arg = $argv[1] ?? '10000';

if ($arg === 'reset') {
    @unlink(__DIR__ . '/data.sqlite');
    echo "Base supprimée. Elle sera recréée au prochain lancement.\n";
    exit;
}

$n  = max(1, (int)$arg);
$db = getDb();

$debut = microtime(true);
$db->beginTransaction();                 // une seule transaction : insertion rapide
$stmt = $db->prepare(file_get_contents(__DIR__ . '/seed.sql'));
// PARAM_INT indispensable : lié comme texte, '10000' serait toujours
// « plus grand » qu'un entier pour SQLite → récursion infinie.
$stmt->bindValue(':n', $n, PDO::PARAM_INT);
$stmt->execute();
$db->commit();

$total = $db->query('SELECT COUNT(*) FROM formations')->fetchColumn();
printf("%d lignes ajoutées en %.2f s — total : %d formations\n",
       $n, microtime(true) - $debut, $total);
