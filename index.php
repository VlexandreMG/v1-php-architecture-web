<?php
// V1 — Le serveur fabrique toute la page.
// Requête SQL, logique PHP et HTML sont dans le même fichier.
require __DIR__ . '/db.php';

// $formations = getDb()
//     ->query('SELECT id, titre, description, niveau FROM formations ORDER BY niveau, titre')
//     ->fetchAll();

// Petite fonction d'échappement : jamais de donnée brute dans le HTML
function e(string $texte): string
{
    return htmlspecialchars($texte, ENT_QUOTES, 'UTF-8');
}

$db = getDb();

// Calcul de l'offset 

$parPage = 20;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) {
    $page = 1;
} 

$offset = ($page - 1) * $parPage;

// Calcul du nombre de pages 
// Ceil -> Avadiho en entier tsotra 
$totalFormations = (int) $db->query('SELECT COUNT(*) FROM formations')->fetchColumn();
$totalPages = (int) ceil($totalFormations / $parPage);


// Requête SQL avec LIMIT et OFFSET 
$stmt = $db->prepare('
    SELECT id, titre, description, niveau 
    FROM formations 
    ORDER BY niveau, titre 
    LIMIT :limit OFFSET :offset
');

$stmt->bindValue(':limit', $parPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$formations = $stmt->fetchAll();
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

    <!-- Navigation de pagination -->
    <nav class="pagination">
        <!-- Bouton Précédent -->
        <?php if ($page > 1): ?>
            <a href="?page=<?= $page - 1 ?>"&laquo>Précedent</a>
        <?php endif?>

        <!-- Liens vers les numéros de page -->
            <a href="?page=<?= $i ?>" class="<?= $i === $page ? 'active' : '' ?>">
                <?= $i ?>
            </a>

        <!-- Bouton Suivant -->
        <?php if ($page <= $totalPages): ?>
            <a href="?page=<?= $page + 1 ?>">Suivant</a>
        <?php endif?>
    </nav>
</body>
</html>
